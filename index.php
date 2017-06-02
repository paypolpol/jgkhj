<?

if ($_SERVER['REQUEST_URI'] == '/')
	$page = 'home';
else
	$page = substr($_SERVER['REQUEST_URI'], 1);


session_start();

include 'config.php';
include 'db.php';


if (file_exists("all/$page.php"))
	include "all/$page.php";

else if ($_SESSION['id'] and file_exists("auth/$page.php"))
	include "auth/$page.php";

else if (!$_SESSION['id'] and file_exists("guest/$page.php"))
	include "guest/$page.php";

else if ($_SESSION['admin'] and file_exists("admin/$page.php"))
	include "admin/$page.php";

else if (is_numeric($page)) {
	$_SESSION['ref'] = $page;
	location('register');
}

else
	exit('Страница 404');


function valid_captcha() {
	if (!$_POST['g-recaptcha-response'])
		message('Капча введена неверно');

	$url = 'https://www.google.com/recaptcha/api/siteverify?secret='.RECAPTCHA_SECRET.'&response='.$_POST['g-recaptcha-response'].'&remoteip='.$_SERVER['REMOTE_ADDR'];
	$data = json_decode(file_get_contents($url));
	if ($data->success == false)
		message('Капча введена неверно');
}


function valid_name() {
	if (!preg_match('/^[A-z0-9]{3,15}$/', $_POST['name']))
		message('Псевдоним может содержать только латинские буквы и цифры без пробелов, длиной от 3 до 15 символов');
}


function valid_wallet() {
	if (substr($_POST['wallet'], 0, 1) != 'P' or !is_numeric(substr($_POST['wallet'], 1)))
		message('Кошелек указан неверно');
}


function top($title) {
	global $page;
	include 'html/top.php';
}



function bottom() {
	include 'html/bottom.php';
}



function message($text) {
	exit('{"message":"'.$text.'"}');
}


function go($url) {
	exit('{"go":"'.$url.'"}');
}


function location($url) {
	exit(header("location: /$url"));
}


function r2f($num) {
	return number_format((float)$num, 2, '.', '');
}


?>