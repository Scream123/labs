<?php
error_reporting(0);
require_once 'inc/lib.inc.php';

set_error_handler('myError');
require_once 'inc/data.inc.php';

// Установка локали и выбор значений даты
setlocale(LC_ALL, "russian");
$day = strftime('%d');
$mon = strftime('%B');
$mon = iconv('windows-1251', 'utf-8', $mon);
$year = strftime('%Y');

/* лаба № 2.4
 *  Получаем текущий час в виде строки от 00 до 23
 * и приводим строку к целому числу от 0 до 23
 */
$hour = (int) strftime('%H');
$welcome = ''; // Инициализируем переменную для приветствия
if($hour >0 && $hour<6) {
  $welcome = " Доброй ночи";
}else if( $hour >=6 && $hour<12){
  $welcome = " Доброе утро";
}else if( $hour >=12 && $hour<18){
  $welcome = " Добрый день";
}else {
  $welcome = " Добрый вечер";
}
//echo $welcome;

// Инициализация заголовков страницы
$title = 'Сайт нашей школы';
$header = "$welcome, Гость!";
$id = strtolower(strip_tags(trim($_GET['id'])));
switch ($id) {
  case 'about':
        $title = 'О сайте';
        $header = 'О нашем сайте' ;
        break;
  case 'contact':
        $title = 'Контакты';
        $header = 'Обратная связь';
        break;
  case 'table':
    $title = 'Таблица умножения';
    $header = 'Таблица умножения';
    break;
  case 'calc':
    $title = 'Он-лайн калькулятор';
    $header = 'Калькулятор';
    break;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title><?= $title?></title>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <div id="header">
    <!-- Верхняя часть страницы -->
    <? require_once 'inc/top.inc.php';?>
  </div>

  <div id="content">
    <!-- Заголовок -->
  <h1><?= $header?></h1>
    <!-- Область основного контента -->
    <? require_once 'inc/index.inc.php';?>


    <!-- Область основного контента -->
    <?php
    switch ($id) {
      case 'about':
            include 'about.php';
            break;
      case 'contact':
        include 'contact.php';
        break;
      case 'table':
        include 'table.php';
        break;
      case 'calc':
        include 'calc.php';
        break;
      default:
            include 'inc/index.inc.php';


    }
    ?>
  </div>
  <div id="nav">
    <!-- Навигация -->
    <? require_once 'inc/menu.inc.php';?>


    <!--лаба 3.4-->

    <?php

    ?>
    <!-- Меню -->

    <!-- Навигация -->
  </div>
  <div id="footer">
    <!-- Нижняя часть страницы -->
    <? require_once 'inc/bottom.inc.php';?>

  </div>
</body>

</html>