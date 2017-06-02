<? top('Вход') ?>

<script src="https://www.google.com/recaptcha/api.js"></script>

<div class="form">
	<h1>Вход</h1>
	<p><input type="text" id="wallet" placeholder="Кошелек"></p>
	<div class="g-recaptcha" data-sitekey="<?=RECAPTCHA_HTML?>"></div>
	<p><button onclick="send_post('account', 'login', 'wallet.g-recaptcha-response')">Войти в аккаунт</button></p>
</div>
<div class="banner">
<div><img src="/img/banner2.png" alt="Реклама"></div>
<div><img src="/img/banner2.png" alt="Реклама"></div>
<div><img src="/img/banner2.png" alt="Реклама"></div>
</div>

<? bottom() ?>