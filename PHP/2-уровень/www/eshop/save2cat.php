<?php
	// ����������� ���������
	require "eshop_db.inc.php";
	require "eshop_lib.inc.php";
	//��������� � ���������� ������ �� �����
	$author = clearData($_POST["author"]);
	$title = clearData($_POST["title"]);
	$pubyear = clearData($_POST["pubyear"],"i");
	$price = clearData($_POST["price"],"i");
	//���������� ������ ������ � ��
	save($author, $title, $pubyear, $price);
	//������������� ������������ �� �������� ���������� ������ ������
	header("Location: add2cat.php");
?>