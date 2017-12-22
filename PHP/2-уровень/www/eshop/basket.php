<?php
	// запуск сессии
	session_start();
	// подключение библиотек
	require "eshop_db.inc.php";
	require "eshop_lib.inc.php";
?>
<html>
<head>
	<title>Корзина пользователя</title>
</head>
<body>
<?php
	if($count){
		echo "<p>Вернуться в <a href='catalog.php'>каталог</a></p>";
	}else{
		echo "<p>Корзина пуста!Вернитесь в <a href='catalog.php'>каталог</a></p>";
	}
?>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
<tr>
	<th>N п/п</th>
	<th>Автор</th>
	<th>Название</th>
	<th>Год издания</th>
	<th>Цена, руб.</th>
	<th>Количество</th>
	<th>Удалить</th>
</tr>
<?php
	//присваиваем переменную для функции
	$goods = myBasket();
	//еременные для подсчета порядковых номеров ($i) и общей суммы заказа ($sum)
	$i = 1; $sum = 0;
	//выведение всех позициий из корзины на экран
	foreach ($goods as $item) {
?>
	<tr>
		<td><?=$i?></td>
		<td><?= $item["author"] ?></td>
		<td><?= $item["title"] ?></td>
		<td><?= $item["pubyear"] ?></td>
		<td><?= $item["price"] ?></td>
		<td><?= $item["quantity"] ?></td>
		<td><a href="delete_from_basket.php?id=<?= $item["id"] ?>">Удалить</a></td>

	</tr>
<?php
		$i++;
		$sum+= $item["price"] * $item["quantity"];
	}
?>
</table>

<p>Всего товаров в корзине на сумму:<?=$sum?>руб.

<div align="center">
	<input type="button" value="Оформить заказ!"
                      onClick="location.href='orderform.php'">
</div>

</body>
</html>







