<?

require "secure/session.inc.php";
require "../inc/config.inc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Форма добавления товара в каталог</title>
</head>
<body>
<p>Перейти в  <a href='../catalog.php'">Каталог</a></p>
<form action="save2cat.php" method="post">
		<p>Название: <input type="text" name="title" size="100">
		<p>Автор: <input type="text" name="author" size="50">
		<p>Год издания: <input type="text" name="pubyear" size="4">
		<p>Цена: <input type="text" name="price" size="6"> грн.
		<p><input type="submit" value="Добавить">
	</form>
</body>
</html>