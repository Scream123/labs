<?php
	//установка кодировки
	header ("Content-Type:text/html; charset= utf-8");
	//Создание объекта и загрузка в него документа
	$sxml = simplexml_load_file("catalog.xml");
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

	foreach ($sxml -> book as $item){
		echo "<tr>";
			echo "<td>".$item->author."</td>";
			echo "<td>".$item->title."</td>";
			echo "<td>".$item->pubyear."</td>";
			echo "<td>".$item->price."</td>";
		echo "</tr>";

	}


?>
	</table>
</body>
</html>