<?php
//лаба№1.1
header('Content-Type:text/html; charset = utf-8');

//лаба№1.6
//автоматически присоединяет файлы с описанием классов к данному файлу
function __autoload($name)
{
    $file = 'classes/' . $name . '.class.php';
    if (file_exists($file)) {
        include $file;
    }
    return false;
}
//Это новый способ
//spl_autoload_register(function ($class) {
//    include 'classes/' . $class . '.class.php';
//});

//лаба№1.5
$user = new SuperUser('Mike', 'Matrix', '123456', 'admin');
echo "Всего супер-пользователей:". $user::$countObjSupUser;

//$user->getInfo();
//print_r($user);
//$user->showInfo();
echo "<br/>";
$user1 = new User('John', 'Link', '123' );
echo "Всего обычных пользователей:" . $user1::$countObjUser;
//$user1 = new User('John', 'Link', '123' );
//$user1->name = 'John';
//$user1->login = 'Link';
//$user1->password = '123';

//$user2 = new User('Steve', 'TRON', '888'  );
//$user2->name = 'Steve';
//$user2->login = 'TRON';
//$user2->password = '888';

//$user3 = new User('Kim', 'Colt', '555');
//$user3->name = 'Kim';
//$user3->login = 'Colt';
//$user3->password = '555';
//$user1->showInfo();
//$user2->showInfo();
//$user3->showInfo();
