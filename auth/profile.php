<? top('Профиль') ?>

<script src="https://www.google.com/recaptcha/api.js"></script>

<h1><?=$_SESSION['name']?></h1>
<p>Ваш баланс: <?=r2f($_SESSION['balance'])?> руб.</p>
<p>Регистрационный IP: <?=$_SESSION['ip']?></p>
<p>Реф. ссылка: http://udav.ml/<?=$_SESSION['id']?></p>
<p>Всего получено бонусов: <?=$_SESSION['total']?></p>

<? if ($_SESSION['protect'] == 1): ?>
<p><input type="hidden" id="protect" value="0">
<button onclick="send_post('account', 'protect', 'protect')">Выключить проверку по IP</button></p>
<? else : ?>
<p><input type="hidden" id="protect" value="1">
<button onclick="send_post('account', 'protect', 'protect')">Включить проверку по IP</button></p>
<? endif; ?>

<p><button onclick="send_post('account', 'pay')">Заказать выплату</button></p>

<h1 class="mt">Список рефералов</h1>


<table>
	<tr><th>#</th><th>Псевдоним</th><th>Баланс</th></tr>
	<?

	if ($_SESSION['reflist']) {
		foreach ($_SESSION['reflist'] as $key => $val) {
			echo '<tr><td>'.($key + 1).'</td><td>'.$val[0].'</td><td>'.r2f($val[1]).' руб.</td></tr>';
		}
	}
	else
		echo '<tr><td>n/a</td><td>n/a</td><td>n/a</td></tr>';
	?>
</table>



<? bottom() ?>