<?php
    include "IGbookDB.class.php";
//класс GbookDB наследующий интерфейс IGbookDB
class GbookDB implements  IGbookDB{
        //константа бБД
        const DB_NAME ="gbook.db";
        //закрытое свойство $_db для хранения объекта соединения с базой данных
        private $_db;
    //конструктор, в котором выполняется подключение к базе данных
    function __construct()
    {
        try{
          //проверкана существование базы данных
          if (!file_exists(self::DB_NAME)) {
              //подключение к БД
              $this->_db = new SQLiteDatabase(self:: DB_NAME);
              //создание таблицы
              $sql = "CREATE TABLE msgs(
                                      id INTEGER PRIMARY KEY,
                                      name TEXT,
                                      email TEXT,
                                      msg TEXT,
                                      datetime INTEGER,
                                      ip TEXT)";
              $result = $this->_db->query($sql);// выполнение запроса к таблице
              if (!$result)
                  throw new SQLiteException(sqlite_error_string($this->_db->lastError()));
          } else {
              $this->_db = new SQLiteDatabase(self:: DB_NAME); //подключение к БД
          }
        }catch(SQLiteException $e){
                exit("<h1>Всё плохо!</h1>");
            }
    }
    //деструктор, в котором выполняется закрытие соединения с базой данных
    function __destruct(){

            unset($this->_db);
    }
    //фильтрация полученных данных
    function  clearData($data){
        //Удаляет экранирование символов, произведенное функцией addslashes()
        $data = stripslashes($data);
        //Удаляет HTML и PHP тэги из строки
        $data = strip_tags($data);
        //Экранирует спецсимволы в строке для использования в запросе
        $data = sqlite_escape_string($data);
        return $data;
    }
    //Опишисание метода savePost.
    function savePost($name, $email, $msg){
        $ip = $_SERVER["REMOTE_ADDR"];
        $dt = time();
        //добавление записей
        $sql = "INSERT INTO msgs(
                                  name,
                                  email,
                                  msg,
                                  ip,
                                  datetime)
                          VALUES(
                                  '$name',
                                  '$email',
                                  '$msg',
                                  '$ip',
                                  $dt)";
     //Исключения SQLite
     try{
        //строку запроса на добавление новой записи
        $res = $this->_db->query($sql);
         //проверка
         if(!$res)
             throw new SQLiteException(
             sqlite_error_string($this->_db->lastError()));
            return true;
         }catch (SQLiteException $e){
                //mail();
                return false;
          }
    }
    //Выборка всех записей из Гостевой книги
    function getAll(){
     //Исключения SQLite
        try {
             //строка запроса на выборку всех данных из таблицы msgs в обратном порядке
            $sql = "SELECT id, name, email, msg, ip, datetime FROM msgs ORDER BY id DESC";
            //Полученик  результата запроса
            $result = $this->_db->arrayQuery($sql, SQLITE_ASSOC);
            //проверка
            if (!is_array($result))
                throw new SQLiteException(
                    sqlite_error_string($this->_db->lastError()));
            //возврат  результата запроса
            return $result;
        }catch(SQLiteException $e){
            return false;

        }
     }
        //Удаление записи из Гостевой книги
        function deletePost($id){
        //Исключения SQLite
            try{
                $sql = "DELETE FROM msgs WHERE id = $id";
                $result = $this->_db->query($sql);
                if (!$result)
                    throw new SQLiteException(sqlite_error_string($this->_db->lastError()));
                return true;
            }catch(SQLiteException $e){
                return false;
            }
        }
}

?>