<?php
//нформация о пользователях
	abstract class AUser {
    public $name; // имя пользователя
    public $login; // логин
    public $password; //пароль

    function __construct($name="", $login="", $password="") {
        $this->name = $name;
        $this->login = $login;
        $this->password = $password;
    }

    abstract function showInfo();
}
