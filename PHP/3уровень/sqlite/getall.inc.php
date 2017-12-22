<?php
/*
ЗАДАНИЕ 1
...
- После каждого сообщения сформируйте ссылку для удаления этой
  записи. Информацию об идентификаторе удаляемого сообщения передавайте методом GET.
*/
    //Получение результата выборки в виде массива
    $users = $gbook -> getAll();
    //проверка запроса
    if(!is_array($users)){
    $errMsg = "Произошла ошибка при выводе записей";
    }else{
        echo "<p>Всего записей в Гостевой книге: ".count($users)."</p>";


foreach ($users as $user){
    $id = $user["id"];
    $name = $user["name"];
    $email =nl2br($user["email"]);
    $msg = $user["msg"];
    $ip = $user["ip"];
    $dt = date("d-m-Y H:i:s",$user["datetime"]*1);
    //Используя цикл, выводит в браузер все сообщения, а также информацию об авторе каждого сообщения в произвольной форме
    echo  <<<LABEL
      <hr>
                    <p>
                    <b><a href="mailto:$email">$name</a> from [$ip] @ $dt
                    <br>    $msg
                    </p>
                    <p align="right">
                    <a href="gbook.php?del=$id">Удалить</a>
                    </p>

LABEL;







  }
    }

?>