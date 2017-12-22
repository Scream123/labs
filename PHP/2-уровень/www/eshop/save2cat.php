<?php
	// подключение библиотек
	require "eshop_db.inc.php";
	require "eshop_lib.inc.php";
	//получение и фильтрация данных из формы
	$author = clearData($_POST["author"]);
	$title = clearData($_POST["title"]);
	$pubyear = clearData($_POST["pubyear"],"i");
	$price = clearData($_POST["price"],"i");
	//сохранение нового товара в БД
	save($author, $title, $pubyear, $price);
	//Переадресация пользователя на страницу добавления нового товара
	header("Location: add2cat.php");
?>