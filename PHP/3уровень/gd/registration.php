<?php
	header("Content-Type:text/html; charset=utf-8");
	//запуск сессии
	session_start();
	$result ='';
	//Проверка на  отправлену формы
	if ($_SERVER["REQUEST_METHOD"]=="POST")
	//проверка на существование сессионной переменной randStr
		if(isset($_SESSION["randStr"])){
			if($_SESSION["randStr"]==$_POST["str"])//Если переменная randStr существует и её значение равно значению введённому пользователем
				$result="Правильно";
			else
				$result= "Не правильно";
		}else{
			$result = "Включи графику!";

		}



/*
ЗАДАНИЕ 1
- Запустите сессию
- Создайте переменную result со значением "пустая строка"("")
- Проверьте, была ли отправлена форма
- Проверьте, существует ли сессионная переменная randStr
    - Если переменная randStr существует и её значение равно значению введённому пользователем,
        присвойте переменной result значение "Правильно"
    - Если переменная randStr существует и её значение не равно значению введённому пользователем,
        присвойте переменной result значение "НЕ правильно"
    - Если переменная randStr не существует,
        присвойте переменной result значение "ВКЛЮЧИ ГРАФИКУ!"
*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Регистрация</title>
</head>
<body>
<h1>Регистрация</h1>
<form action="" method="post">
	<div>
		<img src="noise-picture.php">
	</div>
	<div>
		<label>Введите строку</label>
		<input type="text" name="str" size="6">
	</div>
	<input type="submit" value="OK">
</form>
<?php
	echo $result;
	/*
	ЗАДАНИЕ 2
	- Выведите значение переменной result
	*/
?>
</body>
</html>
