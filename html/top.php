<!DOCTYPE html>
<html>
<head>
	<title><?=$title?></title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="/css/style.css">
	<script type="text/javascript" src="/js/jquery.js"></script>
	<script type="text/javascript" src="/js/sender.js"></script>
</head>
<body>
<div class="wrapper">
	<div class="slide">
		<div><img src="/img/banner.png" alt="Реклама"></div>
		<div><img src="/img/banner.png" alt="Реклама"></div>
		<div><img src="/img/banner.png" alt="Реклама"></div>
	</div>
	<div class="content">
	<div class="menu">
	<? if (in_array($page, array('a_home', 'a_user', 'a_config', 'a_edit'))): ?>
		<a href="/a_home">Главная</a>
		<a href="/a_user">Пользователи</a>
		<a href="/a_config">Конфиг</a>
		<a href="/a_exit">Выход</a>
	<? else: ?>
		<a href="/">Бонус</a>
		<a href="/support">Поддержка</a>
	<? if ($_SESSION['id']): ?>
		<a href="/profile">Профиль</a>
		<a href="/logout">Выход</a>
	<? else: ?>
		<a href="/login">Вход</a>
		<a href="/register">Регистрация</a>
	<? endif; ?>
	<? endif; ?>
	</div>