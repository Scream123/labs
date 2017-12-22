<?php
	include_once 'classes/Favorites.class.php';

	$obj = new Favorites;
	$links = $obj -> getFavorites('getLinksItems');
	$articles = $obj -> getFavorites('getArticlesItems');
	$apps = $obj -> getFavorites('getAppsItems');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<title>Наши рекомендации</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
	div#header{border-bottom:1px solid black;text-align:center;width:80%}
	div#a, div#b, div#c{width:30%; height:200px;float:left}
	
</style>
</head>
<body>
	<div id='header'>
		<h1>Мы рекомендуем</h1>
	</div>
	<div id='a'>
		<h2>Полезные сайты</h2>
		<!-- Список сайтов -->
		<ul>
			<?
			foreach ($links as $link){
			foreach ($link as $item)
				echo "<li><a href='{$item[1]}'>{$item[0]}</a> </li>";
					}
			?>
		</ul>
	</div>
	<div id='b'>
		<h2>Полезные приложения</h2>
		<!-- Список приложений -->
		<ul>
			<?
			foreach ($apps as $app){
				foreach ($app as $item)
					echo "<li><a href='{$item[1]}'>{$item[0]}</a> </li>";
			}
			?>
		</ul>
	</div>
	<div id='c'>
		<h2>Полезные статьи</h2>
		<!-- Список статей -->
		<ul>
		<?
		foreach ($articles as $article){
			foreach ($article as $item)
				echo "<li><a href='{$item[1]}'>{$item[0]}</a> </li>";
		}
		?>
		</ul>


	</div>
</body>
</html>