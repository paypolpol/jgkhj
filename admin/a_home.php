<?

db();

$informer1 = mysqli_fetch_row(mysqli_query($db, 'SELECT COUNT(`id`) FROM `users`'));
$informer2 = mysqli_fetch_row(mysqli_query($db, 'SELECT COUNT(`id`) FROM `users` WHERE `ref` != 0'));
$informer4 = mysqli_fetch_row(mysqli_query($db, 'SELECT SUM(`sum`) FROM `history`'));
$informer5 = mysqli_fetch_row(mysqli_query($db, 'SELECT SUM(`total`) FROM `users`'));

top('Главная страница Админки');

?>


<h1>Главная страница Админки</h1>
<p>Всего пользователей: <?=$informer1[0]?></p>
<p>Всего рефералов: <?=$informer2[0]?></p>
<p>Всего обычных: <?=($informer1[0] - $informer2[0])?></p>
<p>Всего выплачено: <?=r2f($informer4[0])?> руб.</p>
<p>Всего выдано бонусов: <?=$informer5[0]?></p>

<? bottom() ?>