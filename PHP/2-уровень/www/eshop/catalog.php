<?php
	// ������ ������
	session_start();
	// ����������� ���������
	require "eshop_db.inc.php";
	require "eshop_lib.inc.php";
?>
<html>
<head>
	<title>������� �������</title>
</head>
<body>
	<p>������� �<a href="basket.php"> �������</a>:<?=$count?></p>
	<table border="1" cellpadding="5" cellspacing="0" width="100%">
	<tr>
		<th>�����</th>
		<th>��������</th>
		<th>��� �������</th>
		<th>����, ���.</th>
		<th>� �������</th>
	</tr>
<?php
//����������� ���������� ��� �������
$goods = selectAll();
	foreach ($goods as $item){
?>
		<tr>
			<td><?=$item["author"]?></td>
			<td><?=$item["title"]?></td>
			<td><?=$item["pubyear"]?></td>
			<td><?=$item["price"]?></td>
			<td><a href="add2basket.php?id=<?=$item["id"]?>">� �������</a></td>

		</tr>
<?php
	}
?>
</table>
</body>
</html>