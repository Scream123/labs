<?php
//����� ������� ��� ������ mySQL
define("DB_HOST","localhost");
//����� ��� ���������� � �������� ��� ������ mySQL
define("DB_LOGIN","root");
//������ ��� ���������� � �������� ��� ������ mySQL
define("DB_PASSWORD","");
//��� ���� ������
define("DB_NAME","eshop");
// ��� ����� � ������� ������� �������������
define("ORDERS_LOG","orders.log");
// ���������� ������� � ������� �����������z
    $count = 0;
//���������� � �������� ��� ������ mySQL
    mysql_connect(DB_HOST,DB_LOGIN,DB_PASSWORD) or die("�� ���� ����������� � �������� ��");
//��������� ������
  mysql_select_db(DB_NAME) or die(mysql_error());
//SQL-�������� �� ������� ���������� ������� � ������� ������� ������������
    $sql = "SELECT count(*) FROM basket WHERE customer = '".session_id()."' ";
    $res = mysql_query($sql) or die(mysql_error());
    $count = mysql_result($res, 0 ,"count(*)");
?>