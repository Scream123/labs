<?php
	// ������ ������
	session_start();
	// ����������� ���������
	require "eshop_db.inc.php";
	require "eshop_lib.inc.php";
	//������������� ����������
	$customer = session_id();
	//������������� ������
	$goodsid = clearData($_GET["id"],"i");
	//���������� ������
	$quantity = 1;
	//���� ���������� ������ � �������
	$datetime = time();
	//���������� ������ � �������
	 add2basket($customer, $goodsid, $quantity, $datetime);
	//������������� ������������ �� ������� �������
	header("Location: catalog.php");
?>