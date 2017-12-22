<?php
//Класс NewsDB реализующийинтерфейс INewsDB
require_once 'INewsDB.class.php';
class NewsDB implements INewsDB, IteratorAggregate {
    //имя базы данных
    const DB_NAME = 'news.db';

    //лаба 3.1
    //Хранение имени RSS-файла
    const RSS_NAME = 'rss.xml';
    //Хранение заголовка новостной ленты
    const RSS_TITLE = 'Последние новости';
    //Хранение ссылки на саму новостную ленту
    const RSS_LINK = 'http://lessonsphp2016.local:81/less3/news/news.php';

       //Хранение объекта БД
    private $_db = null;

    //лаба№ 2.2 (ур.4)
    private $items = [];

    function __get($name) {
        //Доступ на чтение значения свойства $_db классам-наследникам
        if ($name == '_db') {
            return $this->_db;
            throw new Exception('Unknown property!');
        }
    }
        //Подключение к БД SQLite
        function __construct() {
            //$this->_db = new SQLite3(self::DB_NAME);
            $this->_db = new  PDO('sqlite:'.self::DB_NAME);
            $this->_db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //лаба№3.1(ур.4)

            //Проверка наличия файла
            if (filesize(self::DB_NAME) == 0) {
            try {
                //транзакция
                $this->_db->beginTransaction();

//                $this->_db = new  PDO('sqlite:'.self::DB_NAME);
//
//                $this->_db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $sql = "CREATE TABLE msgs(
                             id INTEGER PRIMARY KEY AUTOINCREMENT,
                             title TEXT,
                             category INTEGER,
                             description TEXT,
                             source TEXT,
                             datetime INTEGER
                       )";
                    $result = $this->_db->exec($sql);
//                    if ($result === false)
//                        echo "Ошибка в запросе";

                    //if ($this->_db->exec($sql))
                        //throw new Exception($this->_db->lastErrorMsg());
                    $sql = "CREATE TABLE category(
                             id INTEGER,
                             name TEXT
                       )";
                    $result = $this->_db->exec($sql);
//                    if ($result === false)
//                        echo "Ошибка в запросе";
//                    if ($this->_db->exec($sql))
//                        throw new Exception($this->_db->lastErrorMsg());
                    $sql = "INSERT INTO category(id, name)
                            SELECT 1 as id, 'Политика' as name
                            UNION SELECT 2 as id, 'Культура' as name
                            UNION SELECT 3 as id, 'Спорт' as name";
                    $result = $this->_db->exec($sql);
//                    if ($result === false)
//                        echo "Ошибка в запросе";
//                    if ($this->_db->exec($sql))
//                        throw new Exception($this->_db->lastErrorMsg());
                    $this->_db->commit();
                }catch (PDOException $e){
//                catch (Exception $e){
                    // $e->getMessage();//просмотр ошибки для себя

                /* Если хотя бы в одном запросе произошла ошибка,
                откатываем всё назад*/
                $this->_db->rollBack();
                    echo 'Всё плохо :(' . $e -> getCode() . ":" . $e -> getMessage();
                    exit;

                }
            }

            //получение категории
            $this->getCategories();
        }

        //Удаление экземпляра класса SQLite3
        function __destruct() {

            unset($this->_db);
        }


    function saveNews($title, $category, $description, $source) {
        $dt = time();
        //Добавление новой записи в таблицу
        $sql = "INSERT INTO  msgs (
                          title, category, description, source, datetime)
                  VALUES (
                           $title, $category, $description, $source, $dt)";

//        $res = $this->_db->exec($sql);
//        if (!$res) return false;
        $result = $this->_db->exec($sql);
        if ($result === false)
            echo "Ошибка в запросе";

        $this->createRss();
        return true;
    }

    //Для внутреннего пользования
    protected function db2Arr($data) {

        $arr = [];

        //while ($row = $data->fetchArray(SQLITE3_ASSOC))
        while($row = $data->fetch(PDO::FETCH_ASSOC))
            $arr[] = $row;
        return $arr;
    }

    function getNews() {
        //Выборка записей
        $sql = "SELECT msgs.id as id, title, category.name as category,
                      description, source, datetime 
                  FROM msgs, category
                  WHERE category.id = msgs.category ORDER BY msgs.id DESC";
        $res = $this->_db->query($sql);

       // if (!$res) return false;
        if ($res === false)
            echo "Ошибка в запросе";
        return $this->db2Arr($res);

    }

    //Удаление новости
    function deleteNews($id) {
        try {
        $sql = "DELETE FROM `msgs` WHERE `id` = '$id'";

        $res = $this->_db->query($sql);

        //if (!$res)
          //  if (!$res) return false;
        if ($res === false)
            echo "Ошибка в запросе";
        return $this->db2Arr($res);
            //throw new SQLiteException(sqlite_error_string($this->_db->lastErrorMsg()));
           // return true;
        //}catch (SQLiteException $e){
        }catch (PDOException $e){
            echo "Удаление не удалось :". $e->getMessage();
            //return false;
       }

    }
    


    //фильтрация полученных данных
    function clearStr($data) {
        $data = trim(strip_tags($data));
        //return $this->_db->escapeString($data);
        return $this->_db->quote($data);
    }

    function clearInt($data) {
        return  abs((int)$data);

    }

    //Формирование RSS-документа
    private  function createRss() {
        $dom = new DOMDocument("1.0", "utf-8");
        //правильное форматирования документа:
        $dom->formatOutput = true; //Форматирует вывод, добавляя отступы и дополнительные пробелы
        $dom->preserveWhiteSpace = false; //Указание не убирать лишние пробелы и отступы

        //корневой элемент rss
        $rss = $dom -> createElement('rss');

        //Привязка его к объекту $dom
        $dom->appendChild($rss);

        $version = $dom-> createAttribute('version');
        $version->value = '2.0';
        $rss->appendChild($version);

        $channel = $dom-> createElement('channel');
        //Привязка его к корневому элементу
        $rss -> appendChild($channel);

        $title = $dom -> createElement('title',self::RSS_TITLE);
        $link = $dom -> createElement('link',self::RSS_LINK);
        $channel -> appendChild($title);
        $channel -> appendChild($link);

        //данные в виде массива из базы данных
        $lenta = $this->getNews();

        if(!$lenta) return false;
        foreach ($lenta as $news) {
            //XML-элемент item для очередной новости
            $item  = $dom -> createElement('item');
            $title  = $dom -> createElement('title', $news['title']);

            $link  = $dom -> createElement('link', '#');

            $description = $dom -> createElement('description');
            // Создаём секцию CDATA
            $cdata = $dom->createCDATASection($news['description']);
            $description -> appendChild($cdata);

            $dt = date('r',$news['datetime']);
            $pubDate  = $dom -> createElement('pubDate', $dt);
            $category  = $dom -> createElement($news['category']);

            //Связка XML-элементов с данными к XML-элементов item
            $item -> appendChild($title);
            $item -> appendChild($link);
            $item -> appendChild($description);
            $item -> appendChild($pubDate);
            $item -> appendChild($category);

            $channel -> appendChild($item);
        }
        $dom-> save(self::RSS_NAME);
    }
    //лаба2.2(ур.4)
    private function getCategories() {
        $sql ="SELECT id, name FROM category";
        $res = $this->_db->query($sql);

        //if (!$res) return false;
        if ($res === false)
            echo "Ошибка в запросе";
       // while ($row = $res->fetchArray(SQLITE3_ASSOC))
        while ($row = $res->fetch(PDO::FETCH_ASSOC))
        $this->items[$row['id']]=$row['name'];
       // var_dump($this->items);

        return $this->items;

}
    function getIterator() {
        // TODO: Implement getIterator() method.
        asort($this->items);
        return (new ArrayIterator($this->items));
    }
}
//$news = new NewsDB();



    
    
    



