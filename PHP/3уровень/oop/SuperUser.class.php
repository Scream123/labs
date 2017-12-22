<?php
//Описание класса SuperUser наследованного от класса User
    class SuperUser extends User implements ISuperUser{
        //свойство
        public $role;
//ќписание в классе SuperUser статические свойства дл¤ подсчета количества созданных объектов
    static $countSuper = 0;
    //описание конструктора
    function __construct($name, $login, $password, $role){
        //задаем начальные значени¤ свойств
        /*это есть у родител¤
         $this -> name = $name;
       $this -> login = $login;
       $this -> password = $password;*/
// вызываем родительский конструктор ипередаем родительскому конструктору необходимые значени¤
        parent:: __construct($name, $login, $password);
        $this -> role = $role;
        //инкрементируем данные свойства
        self:: $countSuper++;
        parent::$countUser--;

    }
    //ќписание метода
    function showInfo(){
        /*это есть у родител¤echo "<p>Name:" .$this->name."<br>";
        "Login:" .$this->login."<br>";
      "Password:" .$this->password."<br>";*/
//вызов родительского метода showInfo() и передаем родительскому методу необходимые значени¤
        parent::showInfo();
        echo "Role:" .$this->role."<br>";
    }
    //ќписание метода getInfo() в классе SuperUser
    function getInfo(){
        $arr = array();
        foreach ($this as $key => $value){
            $arr[$key] = $value;

        }
//возвращает ассоциативный массив, в котором именами ¤чеек ¤вл¤ютс¤ имена свойств объекта, а значени¤ми ¤чеек - значени¤ свойств объекта
        return $arr;
    }

}