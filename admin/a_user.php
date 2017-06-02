<? top('Список пользователей') ?>




<h1>Список пользователей</h1>

<table>
<tr><th>ID</th><th>Реферал</th><th>Псевдоним</th><th>Кошелек</th><th>Баланс</th><th>Получено бонусов</th><th>Редактировать</th></tr>
<?
db();

$query = mysqli_query($db, 'SELECT * FROM `users`');

if (mysqli_num_rows($query)) {
	while ($row = mysqli_fetch_assoc($query)) {
		$button = "send_post('a_edit', 'edit', 'edit$row[id]')";
		echo '<tr><td>'.$row['id'].'</td><td>'.$row['ref'].'</td><td>'.$row['name'].'</td><td>'.$row['wallet'].'</td><td>'.r2f($row['balance']).' руб.</td><td>'.$row['total'].'</td><td><input type="hidden" value="'.$row['id'].'" id="edit'.$row['id'].'"><button onclick="'.$button.'">Редактировать</button></td></tr>';
	}

}
?>
</table>



<? bottom() ?>