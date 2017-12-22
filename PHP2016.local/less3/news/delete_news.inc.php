<?php
//php-код обработки данных для удаления записи из таблицы БД
require_once 'NewsDB.class.php';
//фильтрация полученных
$news = new NewsDB();
$id = $news->clearInt($_GET['id']);

//Проверка на корректность полученных данных
if ($id>0) {
    if ($id) {
        $res = $news->deleteNews($id);
        $errMsg = 'Запись удалена!';
        header('Location: news.php');
       exit;
    } else {
        $errMsg = 'Ошибка при удалении!';
        header('Location: news.php');
        exit;
    }
}