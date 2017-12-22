<?php
    //фильтрация полученных данных
   $id = abs((int) $_GET["del"]);
    //Проверка нп корректность полученных данных
     if($id){
         //вызов метода deletePost
        $result=$gbook-> deletePost($id);
     }else {
         $errMag = "Хакер, не ломай мою Гостевую книгу!";
     }
         //проверка SQLite
        if(!$result){
        $errMsg = "Произошла ошибка при удалении сообщения";
         }else {
            //перезапрос страницы
            header("Location: gbook.php");
            exit;
        }


?>