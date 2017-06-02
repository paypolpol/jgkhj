<?
 
 if ($_POST['send_f']) {
 	valid_captcha();
 	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
 		message('E-mail указан неверно');
 	else if (strlen($_POST['message']) < 10 or strlen($_POST['message']) > 1000)
 		message('Текст сообщения должен быть от 10 до 1000 сиволов');
 	$result = mail(ADMIN_EMAIL, 'new support message', "Сообщение: ".htmlspecialchars($_POST['message'])."\r\n\r\nEmail: $_POST[email]");
 	if ($result)
 		message('Спасибо, ваше сообщение отправлено Администратору сайта');
 	else
 		message('Ошибка отправки сообщения, пожалуйста повторите попытку');
}


top('Служба поддержки') ?>

<script src="https://www.google.com/recaptcha/api.js"></script>

<div class="form">
	<h1>Служба поддержки</h1>
	<p><input type="text" id="email" placeholder="E-mail"></p>
	<p><textarea placeholder="Сообщение" id="message"></textarea></p>
	<div class="g-recaptcha" data-sitekey="<?=RECAPTCHA_HTML?>"></div>
	<p><button onclick="send_post('support', 'send', 'email.message.g-recaptcha-response')">Отправить</button></p>
</div>

<? bottom() ?>