<?php
//РНР-код обработки HTML-формы

// подключение библиотек
require "secure/session.inc.php";
require "../inc/lib.inc.php";
require "../inc/config.inc.php";

////получение и фильтрация данных из формы
	$author = clearData($_POST['author']);
	$title = clearData($_POST['title']);
	$pubyear = clearData($_POST['pubyear'], 'i');
	$price = clearData($_POST['price'], 'i');

//проверка и сохранение нового товара в БД
if(!addItemToCatalog($title, $author, $pubyear, $price)){
	echo 'Произошла ошибка при добавлении товара';
}else{
	header('Location: add2cat.php');
	exit;
}


