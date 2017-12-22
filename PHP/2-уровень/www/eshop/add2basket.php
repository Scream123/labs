<?php
	// запуск сессии
	session_start();
	// подключение библиотек
	require "eshop_db.inc.php";
	require "eshop_lib.inc.php";
	//идентификатор покупателя
	$customer = session_id();
	//идентификатор товара
	$goodsid = clearData($_GET["id"],"i");
	//количество товара
	$quantity = 1;
	//дата добавления товара в корзину
	$datetime = time();
	//Добавление товара в корзину
	 add2basket($customer, $goodsid, $quantity, $datetime);
	//Переадресация пользователя на каталог товаров
	header("Location: catalog.php");
?>