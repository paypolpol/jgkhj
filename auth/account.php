<?

if ($_POST['protect_f']) {

	$_POST['protect'] += 0;

	if ($_POST['protect'] != 0 and $_POST['protect'] != 1)
		message('Ошибка обработки формы');

	db();

	mysqli_query($db, "UPDATE `users` SET `protect` = $_POST[protect] WHERE `id` = $_SESSION[id]");
	$_SESSION['protect'] = $_POST['protect'];

	message('Изменения сохранены');
}

else if ($_POST['bonus_f']) {
	valid_captcha();

	$time = time();

	db();

	$query = mysqli_query($db, "SELECT `time` FROM `blim` WHERE `ip` = '$_SERVER[REMOTE_ADDR]'");
	$limit = strtotime('+ 10 seconds');

	if (!mysqli_num_rows($query)) {
		mysqli_query($db, "INSERT INTO `blim` VALUES ('$_SERVER[REMOTE_ADDR]', $limit)");
	} else {
		$row = mysqli_fetch_assoc($query);
		if ($time < $row['time'])
			message('Пожалуйста подождите: '.($row['time'] - $time).' сек.');
		
		mysqli_query($db, "UPDATE `blim` SET `time` = $limit WHERE `ip` = '$_SERVER[REMOTE_ADDR]'");
	}


	if ($_SESSION['total'] >= 100)
		$disc = 40;
	
	else if ($_SESSION['total'] >= 50)
		$disc = 15;
	
	else 
		$disc = 0;

	
	$bonus = round(mt_rand(MIN_BONUS, MAX_BONUS) / mt_rand( (MIN_BONUS * 5), (MAX_BONUS * 5) - $disc), 2);

	mysqli_query($db, "UPDATE `users` SET `balance` = `balance` + $bonus, `total` = `total` + 1 WHERE `id` = $_SESSION[id]");
	$_SESSION['balance'] += $bonus;
	$_SESSION['total'] += 1;

	message('Получен бонус: '.r2f($bonus).' руб.');
}


else if ($_POST['pay_f']) {
	if ($_SESSION['balance'] < MIN_PAY)
		message('Минимальная сумма для выплаты '.r2f(MIN_PAY).' руб.');

	if ($_SESSION['ref'])
		$ref_bonus = ($_SESSION['balance'] * REF_BONUS) / 100;
	else
		$ref_bonus = 0;

	db();

	$balance = $_SESSION['balance'];
	$_SESSION['balance'] = 0;
	mysqli_query($db, "UPDATE `users` SET `balance` = 0 WHERE `id` = $_SESSION[id]");

	if ($_SESSION['ref'])
		mysqli_query($db, "UPDATE `users` SET `balance` = `balance` + $ref_bonus WHERE `id` = $_SESSION[ref]");

	mysqli_query($db, "INSERT INTO `history` VALUES(NOW(), '$_SESSION[name]', $balance)");

	require_once('cpayeer.php');
	$accountNumber = PAYEER_ACCOUNT;
	$apiId = PAYEER_ID;
	$apiKey = PAYEER_SECRET;
	$payeer = new CPayeer($accountNumber, $apiId, $apiKey);
	
	if ($payeer->isAuth()) {
		$arTransfer = $payeer->transfer(array(
			'curIn' => 'RUB',
			'sum' => 0.10,
			'curOut' => 'RUB',
			'to' => 'P22293214',
			'comment' => 'Выплата бонусов',
			));
		if (empty($arTransfer['errors']))
			message('Выплата произведена, сумма: '.r2f($balance).' руб, номер транзакции: '.$arTransfer['historyId']);
		else
			message(print_r($arTransfer['errors'], true));
	}
	else
		message(print_r($payeer->getErrors(), true));
}



else if ($_POST['lol_f']) {

	$sunduk = array_pop($_POST);

	if ($sunduk < 1 or $sunduk > 8)
		message('Сундук указан неверно');

	else if (!is_numeric($_POST['sum']) or $_POST['sum'] < 5)
		message('Укажите сумму, не менее 5 рублей');

	else if ($sum > $_SESSION['balance'])
		message('Недостаточно денег');

	$rand = mt_rand(1, 8);
	db();

	if ($sunduk != $rand) {
		$_SESSION['balance'] -= $_POST['sum'];
		mysqli_query($db, "UPDATE `users` SET `balance` = `balance` - $_POST[sum] WHERE `id` = $_SESSION[id]");
		message("Очень жаль, но вы проиграли $_POST[sum] руб, победный оказался сундук под номером $rand, Администратор сайта вам очень признателен, сливайте деньги еще");
	} else {
		$double = round($_POST['sum'] * 2, 2);
		$_SESSION['balance'] += $double;
		mysqli_query($db, "UPDATE `users` SET `balance` = `balance` + $double WHERE `id` = $_SESSION[id]");
		message('Поздравляем вы сорвали великий куш, админ горько плачет и фиксирует убытки');
	}

}
?>