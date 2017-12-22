<?php
//php-код обработки данных для добавления записи в таблицу БД
require_once 'news.php';
//Проверка на корректность отправки формы
$t = $news->clearStr($_POST['title']);
$c = $news->clearInt($_POST['category']);
$d =$news->clearStr($_POST['description']);
$s = $news->clearStr($_POST['source']);
if (empty($t) or empty($d)){
    $errMsg = "<h3 style='color: red'>Заполните все поля формы!</h3>";
}else {
    if (!$news->saveNews($t, $c, $d, $s)){
        $errMsg = "Произошла ошибка при добавлении новости";
    }else{
        header('Location: news.php');
        exit;

    }


}
//Проверка удаления записи запроса методом GET

