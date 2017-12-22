<?php
	//установка кодировки
	header("Content-Type:text/html; charset=utf-8");
//Создание объекта DOM
	$dom = new DomDocument();
	//Загрузка XML-документа в объект
	$dom -> load("catalog.xml");// XML file
	/*$dom -> loadXML($str);// XML string
	$dom -> loadHTML($file);// HTML file
	$dom -> loadHTML($str);// HTML string
	*/
		//Получение корневого элемента
		$root = $dom->documentElement;

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
//Заполнение таблицы необходимыми данными
	foreach ($root->childNodes as $book){
		if($book->nodeType==1){
		echo "<tr>";
		foreach ($book->childNodes as $item){
			if($item->nodeType==1){
				echo "<td>";
				echo $item->textContent;
				echo "</td>";

			}
		}
		echo "</tr>";
			}

	}



?>
	</table>
</body>
</html>





