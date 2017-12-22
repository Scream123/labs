<?php
//РНР-код обработки персональных данных покупателя для сохранения
// в текстовый файл и перемещения товаров из корзины покупателя в таблицу

require "inc/lib.inc.php";
require "inc/config.inc.php";

//Получение из веб-формы и обрабока данных заказа
$name = clearData($_POST['name']);
$email = clearData($_POST['email']);
$phone = clearData($_POST['phone']);
$address = clearData($_POST['address']);
$dt = time();
//global $basket;
$order_id = $basket['orderid'];

$order = "$name |$email|$phone|$address|$dt|$order_id\n";


//запись строки в файл
file_put_contents('admin/'. ORDERS_LOG, $order, FILE_APPEND);

saveOrder($dt);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Сохранение данных заказа</title>
</head>
<body>
	<p>Ваш заказ принят.</p>
	<p><a href="catalog.php">Вернуться в каталог товаров</a></p>
</body>
</html>