<?php
	//установка кодировки
	header("Content-Type: text/html; charset =utf-8");
	//создание парсера
	$sax = xml_parser_create("utf-8");
	//функция-обработчик начальных тегов
	function onStart($sax, $tag, $att){
		//проверка на наличие тегов
		if($tag!="CATALOG" and $tag!="BOOK")
		echo "<td>";
		if($tag=="BOOK")
			echo "<tr>";

	}
	//функция-обработчик закрывающих тегов
	function  onEnd($sax, $tag){
		if($tag!="CATALOG" and $tag!="BOOK")
			echo "</td>";
		if($tag=="BOOK")
			echo "</tr>";
	
	}
	//функция-обработчик текстового содержимого
	function onText($sax, $text){
		echo $text;

	}
	//регистрация функций-обработчиков начальных и конечных тегов
	xml_set_element_handler($sax, "onStart", "onEnd");
	//регистрация функции-обработчика текстового содержимого
	xml_set_character_data_handler($sax, "onText");
?>
<html>
	<head>
		<title>Каталог</title>
	</head>
	<body>
	<h1>Каталог книг</h1>
	<table border="1" width="100%">
		<tr>
			<th>Автор</th>
			<th>Название</th>
			<th>Год издания</th>
			<th>Цена, руб</th>
		</tr>
	<?php
		//Запуск парсера
		xml_parse($sax, file_get_contents("catalog.xml"));
	?>
	</table>
	</body>
</html>