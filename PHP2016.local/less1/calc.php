<?php

function clearData($data, $type = 'i') {
    switch ($type) {
        case 'i':
            return $data *1;break;
        case 's':
            return trim(strip_tags($data));break;
    }

}
$output = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //TODO: проверить , все ли поля пришли?
    $n1 = clearData($_POST['num1']);
    $n2 = clearData($_POST['num2']);
    $op = clearData($_POST['operator'], 's');
    $output = "$n1 $op $n2 = ";
    switch ($op) {
        case '+': $output.= $n1+$n2;break;
        case '-': $output.= $n1-$n2;break;
        case '*': $output.= $n1*$n2;break;
        case '/':
            if ($n2 == 0)
                $output = 'Деление на 0 запрещено!';
            else
                $output.= $n1/$n2;
            break;
        default: $output = "неизвестный оператор '$op'";





    }
}
?>


<!--<!DOCTYPE html>-->
<!--<html>-->
<!---->
<!--<head>-->
<!--  <title>Калькулятор</title>-->
 <meta charset="utf-8" />
  <link rel="stylesheet" href="style.css" />
<!--</head>-->
<!---->
<!--<body>-->
<!---->
<!--  <div id="header">-->
<!--    <!-- Верхняя часть страницы -->
<!--    <img src="logo.gif" width="187" height="29" alt="Наш логотип" class="logo" />-->
<!--    <span class="slogan">приходите к нам учиться</span>-->
<!--    <!-- Верхняя часть страницы -->
<!--  </div>-->
<!---->
<!--  <div id="content">-->
<!--    <!-- Заголовок -->
<h1>Калькулятор школьника</h1>
<!--    <!-- Заголовок -->
    <!-- Область основного контента -->

<!--Калькулятор-->
<?php
if ($output){
    echo  "<p>Pезультат: $output</p>";
}
?>
    <form  method ='POST'  action=<?= $_SERVER['REQUEST_URI']?>>
      <label>Число 1:</label>
      <br />
      <input name='num1' value='<?=$n1?>' type='text' />
      <br />
      <label>Оператор: </label>
      <br />
      <input name='operator' value='<?=$op?>' type='text' />
      <br />
      <label>Число 2: </label>
      <br />
      <input name='num2' value='<?=$n2?>' type='text' />
      <br />
      <br />
      <input type='submit' value='Считать'>
    </form>

 <!-- Область основного контента -->
<!--  </div>-->
<!--  <div id="nav">-->
<!--    <h2>Навигация по сайту</h2>-->
<!--    <!-- Меню -->
<!--    <ul>-->
<!--      <li><a href='index.php'>Домой</a>-->
<!--      </li>-->
<!--      <li><a href='about.php'>О нас</a>-->
<!--      </li>-->
<!--      <li><a href='contact.php'>Контакты</a>-->
<!--      </li>-->
<!--      <li><a href='table.php'>Таблица умножения</a>-->
<!--      </li>-->
<!--      <li><a href='calc.php'>Калькулятор</a>-->
<!--      </li>-->
<!--    </ul>-->
<!--    <!-- Меню -->
<!--  </div>-->
<!--  <div id="footer">-->
<!--    <!-- Нижняя часть страницы -->
<!--    &copy; Супер Мега Веб-мастер, 2000 &ndash; 2015-->
<!--    <!-- Нижняя часть страницы -->
<!--  </div>-->
<!--</body>-->
<!---->
<!--</html>-->