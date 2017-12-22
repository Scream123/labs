<?php
/* ЗАДАНИЕ 1
- Подключитесь к серверу mySQL
- Выберите активную Базу Данных 'gbook'
- Проверьте, была ли корректным образом отправлена форма
- Если она была отправлена: отфильтруйте полученные данные,
  сформируйте SQL-оператор на вставку данных в таблицу msgs
  и выполните его. После этого выполните перезапрос страницы, чтобы избавиться от информации, переданной через форму
*/
/*
ЗАДАНИЕ 2
- Сформируйте SQL-оператор на выборку всех данных из таблицы
  msgs в обратном порядке и выполните его. Результат выборки
  сохраните в переменной.
- Закройте соединение с БД
- Получите количество рядов результата выборки и выведите его на экран
- В цикле получите очередной ряд результата выборки в виде ассоциативного массива.
  Таким образом, используя этот цикл, выведите на экран все сообщения, а также информацию
  об авторе каждого сообщения. После каджого сообщения сформируйте ссылку для удаления этой
  записи. Информацию об идентификаторе удаляемого сообщения передавайте методом GET.
*/
/*
ЗАДАНИЕ 3
- Проверьте, был ли запрос методом GET на удаление записи
- Если он был: отфильтруйте полученные данные,
  сформируйте SQL-оператор на удаление записи и выполните его.
  После этого выполните перезапрос страницы, чтобы избавиться от информации, переданной методом GET
*/
//создание констант
define("DB_HOST","localhost");
define("DB_LOGIN","root");
define("DB_PASSWORD","");
define("DB_NAME","gbook");
//подключение к БД
	mysql_connect(DB_HOST,DB_LOGIN,DB_PASSWORD) or die("Ошибка!");

	mysql_select_db(DB_NAME) or die(mysql_error());
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//фильтровка полученных данных
function clearData($data, $type="s") {
	
	switch ($type){
		
		case "s":
			$data = trim(strip_tags($data));break;
			case "i":
			$data = abs((int)$data); break;
	}
	return $data;
}

//проверка запроса на удаление записи
if (isset($_GET["del"])) {
	
	$id = clearData ($_GET["del"], "i");
	if ($id>0) {
		$sql = "DELETE FROM msgs WHERE id = $id";
		mysql_query($sql) or die (mysql_error());
	}
	header ("location: gbook.php");
	exit;
} else if(!empty($_POST['name']) and !empty($_POST['email'])) {

	$n = clearData($_POST['name']);
	$e = clearData($_POST['email']);
	$m = clearData($_POST['msg']);
	//формируем SQL оператор
	$sql ="INSERT INTO msgs(
						`name`,
						email,
						msg)
					   VALUES(
					   '$n','$e','$m')";
	mysql_query($sql) or die(mysql_error());
	header("Location: gbook.php");
	exit;

	$n = clearData($_POST['name']);
	$e = clearData($_POST['email']);
	$m = clearData($_POST['msg']);
	//формируем SQL оператор
	$sql ="INSERT INTO msgs(
							`name`,
							email,
							msg)
							VALUES( 
							'$n','$e','$m')";
	mysql_query($sql) or die(mysql_error());
	header("Location: gbook.php");
	exit;

}
?>

<!DOCTYPE html PUBLIC>
<html>
<head>
	<title>Гостевая книга</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<h1>Гостевая книга</h1>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

	Ваше имя:<br />
	<input type="text" name="name" /><br />
	Ваш E-mail:<br />
	<input type="text" name="email" /><br />
	Сообщение:<br />
	<textarea name="msg" cols="50" rows="5"></textarea><br />
	<br />
	<input type="submit" value="Добавить!" />

</form>

<?php

//формируем SQL-оператор на вставку данных в таблицу msgs
	$sql =" SELECT * FROM msgs ORDER BY id DESC";
	$users =mysql_query($sql) or die(mysql_error());
	echo "<p> Всего записей: " .mysql_num_rows($users)."</p>";
mysql_close();
	while($user = mysql_fetch_assoc($users)) {
	$msg = nl2br($user["msg"]);
		?>
		<hr>
		<p>
			<a href='mailto:<?= $user["email"] ?>'>
				<?= $user["name"] ?>
			</a><br><?=$msg?>
		</p>
		<p align='right'>
			<a href='gbook.php?del=<?= $user["id"] ?>'>
				Удалить</a>
		</p>
		<?php
	}
?>
</body>
</html>