<?php
//РНР-код обработки данных для добавления товара в корзину

// подключение библиотек
require "inc/lib.inc.php";
require "inc/config.inc.php";

$id = clearData($_GET['id'], 'i');
if ($id) {
	add2Basket($id);
}
header('Location:catalog.php');
exit;