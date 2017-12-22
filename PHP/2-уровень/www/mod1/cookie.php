<?php

/*
ЗАДАНИЕ 1
- Инициализируйте переменную для подсчета количества посещений
- Если соответствующие данные передавались через куки
  сохраняйте их в эту переменную
- Нарастите счетчик посещений
- Инициализируйте переменную для хранения значения последнего посещения страницы
- Если соответствующие данные передавались из куки, отфильтруйте их и сохраните в эту переменную
- Установите соответствующие куки
*/
	$visitCounter = 0;
	if(isset($_COOKIE["visitCounter"]))
	$visitCounter = $_COOKIE["visitCounter"];
	$visitCounter++;



		if(isset($_COOKIE["lastVisit"]))
		$lastVisit = $_COOKIE["lastVisit"];
	setcookie("visitCounter", $visitCounter, 0x7FFFFFFF);
	setcookie("lastVisit",date("d-m-Y H:i:s"), 0x7FFFFFFF);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<title>Последний визит</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
</head>
<body>

<h1>Последний визит</h1>

<?php
/*
ЗАДАНИЕ 2
- Выводите информацию о количестве посещений и дате последнего посещения
*/
	if($visitCounter==1)
		echo "<p>Добро пожаловать!";
	else {
		echo "Вы пришли $visitCounter  раз";
		echo "Последнее посещение:  $lastVisit";

	}
?>

</body>
</html>