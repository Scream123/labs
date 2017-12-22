<?php
	// запуск сессии
	session_start();
	// подключение библиотек
	require "eshop_db.inc.php";
	require "eshop_lib.inc.php";

	//получение из формы
	$name = clearData($_POST["name"],"sf");
	$email = clearData($_POST["email"],"sf");
	$phone = clearData($_POST["phone"],"sf");
	$address = clearData($_POST["address"],"sf");
	$customer = session_id();
	$datetime = time();
	//строка из полученных данных
	$order = "$name|$email|$phone|$address|$customer|$datetime\n";
	//проверка существования файла,если файл уже существует, данные будут дописаны в конец файла.
	file_put_contents(ORDERS_LOG,$order,FILE_APPEND);
	//вызов функции для пересохранения купленных товаров из корзины в таблицу orders
	resave($datetime);
?>
<html>
<head>
	<title>Сохранение данных заказа</title>
</head>
<body>
	<p>Ваш заказ принят.</p>
	<p><a href="catalog.php">Каталог товаров</a></p>
</body>
</html>