<?

if ($_POST['save_f']) {
	$data = "<?\r\n";
	array_shift($_POST);
	foreach ($_POST as $key => $val)
		$data .= "define('$key', '$val');\r\n";
	$data .= "?>";
	file_put_contents('config.php', $data);
	message('Сохранено');
}




top('Редактор конфига') ?>

<div class="form">
	<h1>Конфиг сайта</h1>
</div>

<div class="form">
	<?
	$file = file('config.php');
	array_shift($file);
	array_pop($file);
	foreach ($file as $key => $val) {
		$val = substr($val, 8); // удаляем первые 8 символов
		$val = substr($val, 0, -5); // удаляем последние 4 символа
		$exp = explode("', '", $val); // разбиваем данные
		$input .= ".$exp[0]";
		echo '<p>'.$exp[0].'</p><p><input type="text" id="'.$exp[0].'" value="'.$exp[1].'"></p>';
	}

	?>
</div>

<div class="form">
	<p><button onclick="send_post('a_config', 'save', '<?=substr($input, 1)?>')">Сохранить</button></p>
</div>

<? bottom() ?>