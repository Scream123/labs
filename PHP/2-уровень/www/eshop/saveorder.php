<?php
	// ������ ������
	session_start();
	// ����������� ���������
	require "eshop_db.inc.php";
	require "eshop_lib.inc.php";

	//��������� �� �����
	$name = clearData($_POST["name"],"sf");
	$email = clearData($_POST["email"],"sf");
	$phone = clearData($_POST["phone"],"sf");
	$address = clearData($_POST["address"],"sf");
	$customer = session_id();
	$datetime = time();
	//������ �� ���������� ������
	$order = "$name|$email|$phone|$address|$customer|$datetime\n";
	//�������� ������������� �����,���� ���� ��� ����������, ������ ����� �������� � ����� �����.
	file_put_contents(ORDERS_LOG,$order,FILE_APPEND);
	//����� ������� ��� �������������� ��������� ������� �� ������� � ������� orders
	resave($datetime);
?>
<html>
<head>
	<title>���������� ������ ������</title>
</head>
<body>
	<p>��� ����� ������.</p>
	<p><a href="catalog.php">������� �������</a></p>
</body>
</html>