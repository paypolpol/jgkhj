<?
function db() {
	global $db;
	$db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if (!$db)
		exit('Ошибка подключеня к БД');
}
?>