<?php
require_once 'UserAbstract.class.php';
class User extends UserAbstract {
    public $name;
    public $login;
    public $password;

    //лаба№1.5
    public static $countObjUser = 0;



    //выводит информацию о пользователе в произвольной форме
    function showInfo()
    {

        echo "<hr>Name: $this->name<br/>
                  Login: $this->login<br/>
                  Password: $this->password<br/>";

    }

    //Лаба№1.2
    function __construct($n, $l, $p) {
        $this->name = $n;
        $this->login = $l;
        $this->password = $p;

        self::$countObjUser++;

        //Лаба№1.6
     //   echo __CLASS__;
    }

}