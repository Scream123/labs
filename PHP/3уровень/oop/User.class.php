<?php
// Информация о пользователях
	class User extends AUser{
    //свойства объектов
    public $name;
    public $login;
    public $password;
    //Описание в классе User  статические свойства для подсчета количества созданных объектов(зад.12)
     static $countUser = 0;// Счетчик
    //свойство objNum, которое хранит порядковый номер объекта.(задание№15)
     protected $objNum = 0;
    const INFO_TITLE = "<h3>Данные пользователя :</h3>";
    //описание конструктора
    function __construct($name="", $login="", $password="") {
        /*//инкрементируем данные свойства
        self:: $countUser++;*/

        //генерируем исключение, если введены не все данные
        try{
            if ($name=='' or $login=='' or $password=='')
                //описываем перехват исключения
                throw new Exception("Введены не все данные!");
            $this->name = $name;
            $this->login = $login;
            $this->password = $password;
            $this->objNum+=++self::$countUser;
        }catch (Exception $e){
            //выводим в браузер сообщение об ошибке
            echo "произошла ошибка", $e -> getMessage(),
            "в строке", $e-> getLine(),
            "в файле",  $e->getFile();

        }

    }
    //описываем метод __clone()
    function __clone(){
        //свойства объектов
        $this -> name = "Guest";
        $this-> login = "guest";
        $this-> password = "qwerty";
        self::$countUser++;
        //присваиваем свойству objNum, порядковый номер объекта.
          $this->objNum++;
    }
    //описание метода showInfo()
    function showInfo(){
//Метод showInfo() выводит значения свойств объектов
        echo "<p>Name: " . $this->name . "<br>";
        echo "Login: " . $this->login . "<br>";
        echo "Password: " . $this->password . "<br>";
    }
    //метод  showTitle() (9 задание)
    function showTitle(){
        //выводим в браузер значение константы INFO_TITLE
        print(self::INFO_TITLE);// или вот так: echo self::INFO_TITLE;
    }
    function __toString() {
        return "Объект #".$this->objNum.": ".$this->name;
    }


}