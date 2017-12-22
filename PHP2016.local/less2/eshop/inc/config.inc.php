<?php
require_once 'lib.inc.php';
//Основные настройки сайта
define('DB_HOST', 'localhost');
define('DB_LOGIN', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'eshop');


//соединение с сервером базы данных MySQL
$conn = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());

//Файл с данными пользователя
define('ORDERS_LOG', 'orders.log');
//хранение корзины пользователя
$basket = [];
//хранение количества товаров в корзине пользователя
$count = 0;
//Создание или чтение корзины пользователя
basketInit();