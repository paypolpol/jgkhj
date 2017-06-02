<? top('Главная страница') ?>

<script src="https://www.google.com/recaptcha/api.js"></script>

<div class="form">
	<h1>Получи бонус</h1>
	<p>Получи бесплатно бонус до 1 руб.</p>
	<div class="g-recaptcha" data-sitekey="<?=RECAPTCHA_HTML?>"></div>
	<p><button onclick="send_post('account', 'bonus', 'g-recaptcha-response')">Получить</button></p>
</div>


<h1 class="mt">ТОП 10 самых активных</h1>
<table>
	<tr><th>Псевдоним</th><th>Получено бонусов</th></tr>
	<? include 'cache/top1.txt' ?>
</table>


<h1 class="mt">Последние 10 выплат</h1>
<table>
	<tr><th>Дата</th><th>Псевдоним</th><th>Сумма</th></tr>
	<? include 'cache/top2.txt' ?>
</table>

<? bottom() ?>