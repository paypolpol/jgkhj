<?

db();

if ($_POST['edit_f']) {
	$id = array_pop($_POST);
	if (!is_numeric($id))
		message('ID пользователя указан неверно');
	$_SESSION['edit_id'] = $id;
	go('a_edit');
}

else if ($_POST['save_f']) {
	if (!is_numeric($_POST['ref']))
		message('ID реферала указано неверно');
	else if (!is_numeric($_POST['balance']))
		message('Баланс указан неверно');
	else if (!is_numeric($_POST['total']))
		message('Общее кол-во бонусов указано неверно');
	else if (!filter_var($_POST['ip'], FILTER_VALIDATE_IP))
		message('IP указан неверно');
	else if ($_POST['protect'] != 1 and $_POST['protect'] != 0)
		message('Проверка входа по IP указана неверно');
	else if ($_POST['ban'] != 1 and $_POST['ban'] != 0)
		message('Блокировка указана неверно');

	valid_wallet();
	valid_name();
	mysqli_query($db, "UPDATE `users` SET `ref` = $_POST[ref], `balance` = $_POST[balance], `total` = $_POST[total], `ip` = '$_POST[ip]', `protect` = $_POST[protect], `ban` = $_POST[ban], `name` = '$_POST[name]', `wallet` = '$_POST[wallet]' WHERE `id` = $_SESSION[edit_id]");
	message('Сохранено');
}



$row = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `users` WHERE `id` = $_SESSION[edit_id]"));


top('Редактор пользователя') ?>


<div class="form">
	<h1><?=$row['name']?></h1>
	<p>Реферал</p>
	<p><input type="text" id="ref" value="<?=$row['ref']?>"></p>
	<p>Псевдоним</p>
	<p><input type="text" id="name" value="<?=$row['name']?>"></p>
	<p>Кошелек</p>
	<p><input type="text" id="wallet" value="<?=$row['wallet']?>"></p>
	<p>Баланс</p>
	<p><input type="text" id="balance" value="<?=$row['balance']?>"></p>
	<p>IP</p>
	<p><input type="text" id="ip" value="<?=$row['ip']?>"></p>
	<p>Проверка входа по IP</p>
	<p><select id="protect"><?=str_replace('value="'.$row['protect'].'"', 'value="'.$row['protect'].'" selected', '<option value="0">Выкл.</option><option value="1">Вкл.</option>')?></select></p>
	<p>Заблокирован</p>
	<p><select id="ban"><?=str_replace('value="'.$row['ban'].'"', 'value="'.$row['ban'].'" selected', '<option value="0">Нет</option><option value="1">Да</option>')?></select></p>

	<p>Всего получено бонусов</p>
	<p><input type="text" id="total" value="<?=$row['total']?>"></p>
	<p><button onclick="send_post('a_edit', 'save', 'ref.name.wallet.balance.ip.total.protect.ban')">Сохранить</button></p>
</div>

<? bottom() ?>