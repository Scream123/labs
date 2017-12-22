<?php
//лаба№ 3.2

//Хранение адреса RSS-потока
const RSS_URL = 'http://lessonsphp2016.local/less3/news/rss.xml';
//Хранение RSS-документа на локальном сервере
const FILE_NAME = 'news.xml';
//время хранения документа(кэширование)
const RSS_TTL = 3600;

//Закачивает RSS-документ с адреса  и сохраняет его на сервере для  обновления
function download($url, $filename) {

	$file = file_get_contents($url);
	//сохраняет его на локальном сервере
	if ($file) file_put_contents($filename, $file);
}
if (!is_file(FILE_NAME))
	//закачивает RSS-документ с адреса RSS_URL
		download(RSS_URL, FILE_NAME);

?>
<!DOCTYPE html>

<html>
<head>
	<title>Новостная лента</title>
	<meta charset="utf-8" />
</head>
<body>

<h1>Последние новости</h1>
<?php
//зачитываем с помощью SimpleXML RSS-документ
$xml = simplexml_load_file(FILE_NAME);
$i = 1; //ограничение на определённое кол-во

foreach ($xml->channel->item as $item) {
	echo <<<RSS
		<h3>{$item->title}</h3>
		<p>
			{$item->description}<br>
		<strong>Категория: {$item->category}</strong>	
		<em>Опубликовано: {$item->pubDate}</em>
		</p>
RSS;
	$i++;
	if ($i>5) break;
}

//проверка загрузки свежего RSS-файла
if (time() > filemtime(FILE_NAME) + RSS_TTL)
download(RSS_URL, FILE_NAME);
?>
</body>
</html>