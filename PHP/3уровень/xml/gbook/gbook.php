<?php
	//установка кодировки
	header("Content-Type:text/html; charset=utf-8");
	//константа для хранения имени XML-файла
	define("USERS_LOG", "users.xml");
	//Проверка отправки HTML-формы
	if($_SERVER["REQUEST_METHOD"]=="POST") {
		//фильтрация полученных данных
		$name = stripslashes(trim(strip_tags($_POST["name"])));
		$email = stripslashes(trim(strip_tags($_POST["email"])));
		$msg = stripslashes(trim(strip_tags($_POST["msg"])));
		//данные об IP-адресе пользователя
		$ip = $_SERVER["REMOTE_ADDR"];
		//данные о текущих дате и времени
		$dt = time();


		//Создание объекта DOMDocument
		$dom = new DOMDocument("1.0", "utf-8");
		//форматирование вывода
		$dom -> formatOutput = true;//Форматирует вывод, добавляя отступы и дополнительные пробелы.
		$dom ->preserveWhiteSpace = false;//Указание не убирать лишние пробелы и отступы. По умолчанию TRUE.

		//Проверка на существование xml-документа с данными
		if (!file_exists(USERS_LOG)) {
			$root = $dom->createElement('users');// создание корневого элемента
			$dom->appendChild($root);//Присоединение новых элементов к родительскому элементу
		}else {
			$dom->load(USERS_LOG);//Загрузка XML-документа
			$root = $dom->documentElement;////Доступ к корневому элементу
		}

		//Cоздание новогоXML-элемента "user" для очередной записи
		$user = $dom->createElement('user');
		//Cоздание XML-элементов для всех данных Гостевой книги:
		$n = $dom->createElement("name", $name);
		$e = $dom->createElement('email', $email);
		$m = $dom->createElement('msg', $msg);
		$i = $dom->createElement('ip', $ip);
		$d = $dom->createElement('datetime', $dt);
			//Cоздание текстовых узлов для всех указанных элементов
			//Привязка текстовых узлов к соответствующим XML-элементам
			$user->appendChild($n);
			$user->appendChild($e);
			$user->appendChild($m);
			$user->appendChild($i);
			$user->appendChild($d);
		//Привязка XML-элементов с данными заказа к XML-элементу "user"
		$root->appendChild($user);
			//Привязка XML-элемента "user" к корневому элементу "users"
			// Сохранение файла
			$dom->save(USERS_LOG);
		//Перезапрос страницы для избавления от посланных данных
		header("Location: gbook.php");
			exit;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<title>Гостевая книга</title>
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
	//Создание объекта SimpleXML и загрузка в него XML-документа
	//проверка
	if(file_exists(USERS_LOG)) {
		$sxml = simplexml_load_file(USERS_LOG);
//Вывод в браузер всех сообщений, а также информации  об авторе каждого сообщения в произвольной форме в обратном порядке
		$users=(array)$sxml;
	if($users['user'])
		$users = array_reverse($users['user']);
		else
			$users = (array)$users["users"];//если только одна запись

		foreach ($users as $user ){
			$dt = date("d-m-Y H:i:s", $user->datetime*1);
			$msg = nl2br($user->msg);
			echo <<<LABEL
			<hr>
			<p>
			<a href="mailto:{$user->email}">{$user->name}</a>  [{$user->ip}] @ 
			{$dt}<br>
			{$msg}
			</p>
LABEL;
		}
	}



/*
ЗАДАНИЕ 4

- Выведите в браузер все сообщения, а также информацию
  об авторе каждого сообщения в произвольной форме
  в обратном порядке
*/
?>

</body>
</html>