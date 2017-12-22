<?php
//адрес сервера баз данных mySQL
define("DB_HOST","localhost");
//логин дл€ соединени€ с сервером баз данных mySQL
define("DB_LOGIN","root");
//пароль дл€ соединени€ с сервером баз данных mySQL
define("DB_PASSWORD","");
//им€ базы данных
define("DB_NAME","eshop");
// имя файла с личными данными пользователей
define("ORDERS_LOG","orders.log");
// количество товаров в корзине пользователz
    $count = 0;
//соединение с сервером баз данных mySQL
    mysql_connect(DB_HOST,DB_LOGIN,DB_PASSWORD) or die("Ќе могу соединитьс€ с сервером Ѕƒ");
//¬ыборбазы данных
  mysql_select_db(DB_NAME) or die(mysql_error());
//SQL-оператор на выборку количества товаров в корзине данного пользовател€
    $sql = "SELECT count(*) FROM basket WHERE customer = '".session_id()."' ";
    $res = mysql_query($sql) or die(mysql_error());
    $count = mysql_result($res, 0 ,"count(*)");
?>