<?php
//РНР-код обработки данных для удаления товара из корзины

// подключение библиотек
require "inc/lib.inc.php";
require "inc/config.inc.php";

$id = clearData($_GET['id'], 'i');
if ($id) {
	deleteItemFromBasket($id);
	}
header('Location: basket.php');
exit;

