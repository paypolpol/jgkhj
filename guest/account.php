<?

if ($_POST['register_f']) {

	valid_captcha();
	valid_name();
	valid_wallet();

	db();

	if (mysqli_num_rows(mysqli_query($db, "SELECT `id` FROM `users` WHERE `wallet` = '$_POST[wallet]'")))
		message('Этот кошелек уже зарегистрирован');

	if ($_SESSION['ref'])
		$ref = $_SESSION['ref'];
	else
		$ref = 0;

	mysqli_query($db, "INSERT INTO `users` VALUES('', $ref, '$_POST[name]', '$_POST[wallet]', 0, '$_SERVER[REMOTE_ADDR]', 0, 0, 0)");

	message('Регистрация завершена');
}


else if ($_POST['login_f']) {

	valid_captcha();
	valid_wallet();
	db();

	$query = mysqli_query($db, "SELECT * FROM `users` WHERE `wallet` = '$_POST[wallet]'");

	if (!mysqli_num_rows($query))
		message('Аккаунт не найден');

	$row = mysqli_fetch_assoc($query);


	if ($row['protect'] == 1 and $row['ip'] != $_SERVER['REMOTE_ADDR'])
		message('Доступ с этого IP запрещен');
	else if ($row['ban'] == 1)
		message('Аккаунт заблокирован');

	foreach ($row as $key => $val)
		$_SESSION[$key] = $val;

	$refq = mysqli_query($db, "SELECT `name`, `balance` FROM `users` WHERE `ref` = $_SESSION[id] ORDER BY `id` DESC LIMIT 10");

	if (mysqli_num_rows($refq)) {
		while ($refr = mysqli_fetch_assoc($refq))
			$_SESSION['reflist'][] = array($refr['name'], $refr['balance']);
	}
	
	go('profile');

}



else if ($_POST['bonus_f'])
	message('Для получения бонуса пройдите регистрацию');

?>