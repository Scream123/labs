<?php
    //сперва отфильтруем отправу формы
    $name = $gbook -> clearData($_POST["name"]);
    $email = $gbook -> clearData($_POST["email"]);
    $msg = $gbook -> clearData($_POST["msg"]);

  //проверка на корректность отправки HTML-формы
    if(!empty($name) and !empty($email) and !empty($msg)){
        //вызываем метод savePost  и передаем данные
        $res = $gbook->savePost($name, $email, $msg);
        //проверка успешный ли запрос SQLite
        if($res)
        //перезапрос страницы, чтобы избавиться от информации, переданной через форму
        header("Location: gbook.php");
        else $errMsg = "Произошла ошибка при добавлении сообщения";
    }else{
        $errMsg="Заполните все поля формы!";
    }
?>