<?php
	// запуск сессии
	session_start();
	// подключение библиотек
	require "eshop_db.inc.php";
	require "eshop_lib.inc.php";
	//Получение идентификатора удаляемого товара
	$id = clearData($_GET["id"],"i");
	//Вызов функции basketDel() для данного товара
	basketDel($id);
	//Переадресация пользователя на корзину заказов
	header("Location: basket.php");
?>