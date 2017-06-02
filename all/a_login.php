<?
 
 if ($_POST['login_f']) {
 	valid_captcha();
 	if ($_POST['login'] != ADMIN_LOGIN or $_POST['password'] != ADMIN_PASSWORD)
 		message('Логин или пароль указан неверно');
 	else if (ADMIN_IP and $_SERVER['REMOTE_ADDR'] != ADMIN_IP)
 		message('Доступ с этого IP запрещен');
 	$_SESSION['admin'] = 1;
 	go('a_home');
 }


top('Вход в Админку') ?>

<script src="https://www.google.com/recaptcha/api.js"></script>
<div class="form">
	<h1>Вход в Админку</h1>
	<p><input type="text" id="login" placeholder="Логин"></p>
	<p><input type="password" id="password" placeholder="Пароль"></p>
	<div class="g-recaptcha" data-sitekey="<?=RECAPTCHA_HTML?>"></div>
	<p><button onclick="send_post('a_login', 'login', 'login.password.g-recaptcha-response')">Войти в Админку</button></p>
</div>

<? bottom() ?>