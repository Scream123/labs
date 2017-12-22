<?php
//Подключение файла с описанием класса GbookDB
	include "GbookDB.class.php";
	// объект gbook, экземпляр класса GbookDB
	$gbook = new GbookDB();
	//переменная
	$errMsg = "";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Проверка на отправку HTML-формы
	if($_SERVER["REQUEST_METHOD"]=="POST")
		//подключение файла с кодом для обработки HTML-формы
		include "savepost.inc.php";
	//Проверка удаления записи запроса методом GET
	if(isset($_GET["del"]))
	include "deletepost.inc.php";


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<title>Гостевая книга</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<h1>Гостевая книга</h1>
<?php
	//проверка на наличие значения в переменной
	if($errMsg){
		echo $errMsg;
	}

?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

Ваше имя:<br />
<input type="text" name="name" /><br />
Ваш e-mail:<br />
<input type="text" name="email" /><br />
Сообщение:<br />
<textarea name="msg" cols="50" rows="5"></textarea><br />
<br />
<input type="submit" value="Добавить!" />

</form>

<?php
//Подключение файла с кодом для обработки полученных записей Гостевой книги
	include "getall.inc.php";

?>

</body>
</html>