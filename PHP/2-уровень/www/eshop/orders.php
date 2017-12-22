<?php
	// запуск сессии
	session_start();
	// подключение библиотек
	require "eshop_db.inc.php";
	require "eshop_lib.inc.php";
?>
<html>
<head>
	<title>Поступившие заказы</title>
</head>
<body>
<h2>Поступившие заказы:</h2>
<?php
//вызов функции getOrders() и сохранение результата её работы
	$orders = getOrders();
	//проверка на существование файла
	if(is_array($orders)){
//выводим информацию обо всех заказах
	foreach ($orders as $order){
?>
<hr>
<p><b>Заказчик</b>: <?=$order["name"]?></p>
<p><b>Email</b>: <?=$order["email"]?></p>
<p><b>Телефон</b>: <?=$order["phone"]?></p>
<p><b>Адрес доставки</b>: <?=$order["address"]?></p>
<p><b>Дата размещения заказа</b>: <?=date("d-m-Y H:i:s",$order["datetime"])?></p>
<h3>Купленные товары:</h3>
<table border="1" cellpadding="5" cellspacing="0" width="90%">
	<tr>
		<th>N п/п</th>
		<th>Автор</th>
		<th>Название</th>
		<th>Год издания</th>
		<th>Цена, руб.</th>
		<th>Количество</th>
	</tr>
<?php
		$i = 1; $sum = 0;

		foreach ($order["goods"] as $item){
?>
	<tr>
		<td><?= $i?></td>
		<td><?= $item["author"] ?></td>
		<td><?= $item["title"] ?></td>
		<td><?= $item["pubyear"] ?></td>
		<td><?= $item["price"] ?></td>
		<td><?= $item["quantity"] ?></td>


	</tr>
<?php
			$i++;
			$sum += $item["price"] * $item["quantity"];
		}
?>
</table>
<p>Всего товаров в заказе на сумму:<?= $sum ?> руб.
<?php

	}//end of big foreacb
	}//end Of if(is_array($orders))
?>

</body>
</html>