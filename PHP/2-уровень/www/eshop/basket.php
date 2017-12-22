<?php
	// ������ ������
	session_start();
	// ����������� ���������
	require "eshop_db.inc.php";
	require "eshop_lib.inc.php";
?>
<html>
<head>
	<title>������� ������������</title>
</head>
<body>
<?php
	if($count){
		echo "<p>��������� � <a href='catalog.php'>�������</a></p>";
	}else{
		echo "<p>������� �����!��������� � <a href='catalog.php'>�������</a></p>";
	}
?>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
<tr>
	<th>N �/�</th>
	<th>�����</th>
	<th>��������</th>
	<th>��� �������</th>
	<th>����, ���.</th>
	<th>����������</th>
	<th>�������</th>
</tr>
<?php
	//����������� ���������� ��� �������
	$goods = myBasket();
	//��������� ��� �������� ���������� ������� ($i) � ����� ����� ������ ($sum)
	$i = 1; $sum = 0;
	//��������� ���� �������� �� ������� �� �����
	foreach ($goods as $item) {
?>
	<tr>
		<td><?=$i?></td>
		<td><?= $item["author"] ?></td>
		<td><?= $item["title"] ?></td>
		<td><?= $item["pubyear"] ?></td>
		<td><?= $item["price"] ?></td>
		<td><?= $item["quantity"] ?></td>
		<td><a href="delete_from_basket.php?id=<?= $item["id"] ?>">�������</a></td>

	</tr>
<?php
		$i++;
		$sum+= $item["price"] * $item["quantity"];
	}
?>
</table>

<p>����� ������� � ������� �� �����:<?=$sum?>���.

<div align="center">
	<input type="button" value="�������� �����!"
                      onClick="location.href='orderform.php'">
</div>

</body>
</html>







