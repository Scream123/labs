<?
//файл журнала

//текущая временная метка(timestamp)
$t = time();
$dt = date("Y-m-d",$t);
$page = $_SERVER['REQUEST_URI'];
$ref = $_SERVER['HTTP_REFERER'];
$path = "$dt | $page | $ref\n";

//запись строки в файл
 file_put_contents('log/'.PATH_LOG, $path, FILE_APPEND) or die('Не могу открыть файл!');
