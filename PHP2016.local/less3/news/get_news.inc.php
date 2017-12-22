<?php
//Вывод списка записей из таблицы БД
require_once 'NewsDB.class.php';
?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Каталог товаров</title>
    </head>
<body>
<?php

$news = new NewsDB();

$posts = $news->getNews();
//print_r($array);
if ($posts== false){
echo "Произошла ошибка при выводе новостной ленты";
    exit;
}


//выборка всех записей
foreach ($posts as $post) {
?>
    <br/><hr><h3><?= $post['title'];?></h3>
    <p><b>Категория:</b><?=$post['category'];?></p>
     <p><?=$post['description'];?></p>
     <p>Источник: <a href="<?=$post['source']?>"><?=$post['source']?></a></p>
     <p>Опубликовано: <?=date('d-m-Y',$post['datetime']);?></p>
    <p><a href="delete_news.inc.php?id=<?=$post['id']?>">Удалить новость</a></p>

<?php
}



