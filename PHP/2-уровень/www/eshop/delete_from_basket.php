<?php
	// ������ ������
	session_start();
	// ����������� ���������
	require "eshop_db.inc.php";
	require "eshop_lib.inc.php";
	//��������� �������������� ���������� ������
	$id = clearData($_GET["id"],"i");
	//����� ������� basketDel() ��� ������� ������
	basketDel($id);
	//������������� ������������ �� ������� �������
	header("Location: basket.php");
?>