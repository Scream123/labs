<?php
include "INewsDB.class.php";
class NewsDB implements INewsDB, IteratorAggregate{

	const DB_NAME = 'news.db';
	protected $_db;
	protected $_items=[];

	function __construct(){
		/*if(is_file(self::DB_NAME)){
			//$this->_db = new SQLite3(self::DB_NAME);
			//PDO
			$this->_db = new PDO('sqlite:'.self::DB_NAME);
			$this->_db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



		}else{
			//$this->_db = new SQLite3(self::DB_NAME);
			//PDO
			$this->_db = new PDO('sqlite:'.self::DB_NAME);
			$this->_db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


			$sql = "CREATE TABLE msgs(
									id INTEGER PRIMARY KEY AUTOINCREMENT,
									title TEXT,
									category INTEGER,
									description TEXT,
									source TEXT,
									datetime INTEGER
								)";
			$this->_db->exec($sql) or $this->_db->lastErrorMsg();
			$sql = "CREATE TABLE category(
										id INTEGER PRIMARY KEY AUTOINCREMENT,
										name TEXT
									)";
			$this->_db->exec($sql) or $this->_db->lastErrorMsg();
			$sql = "INSERT INTO category(id, name)
						SELECT 1 as id, Политика as name
						UNION SELECT 2 as id, Культура as name
						UNION SELECT 3 as id, Спорт as name";
			$this->_db->exec($sql) or $this->_db->lastErrorMsg();
		}*/
		try {
			$dbExists = is_file(self::DB_NAME) ? true : false;

			$this->_db = new PDO('sqlite:'.self::DB_NAME);
			$this->_db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			if (!$dbExists) {
				$this->_db->exec("CREATE TABLE msgs(
     id INTEGER PRIMARY KEY AUTOINCREMENT,
     title TEXT,
     category INTEGER,
     description TEXT,
     source TEXT,
     datetime INTEGER
    )");
				$this->_db->exec("CREATE TABLE category(
     id INTEGER PRIMARY KEY AUTOINCREMENT,
     name TEXT
    )");
				$this->_db->exec("INSERT INTO category(id, name)
     SELECT 1 as id, Политика as name
     UNION SELECT 2 as id, Культура as name
     UNION SELECT 3 as id, Спорт as name");
			}
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
		//вызываем метод
		$this->getCategories();
	}
		//protected function getCategories(){
		public function getCategories(){
			$sql ="SELECT id, name FROM category";
			$result = $this->_db->query($sql);


			//while($root = $result->fetchArray(SQLITE3_ASSOC))
			while($root = $result->fetch(PDO::FETCH_ASSOC))

				//ключи элементов массива соответствуют  значениям поля id и name
				$this->_items[$root['id']] = $root['name'];
			return $this->_items;
		}

		//метод Итератор
		function getIterator(){
			return new ArrayIterator($this->_items);

		}

	function __destruct(){
		unset($this->_db);
	}
	function saveNews($title, $category, $description, $source){

		$dt = time();
		$sql = "INSERT INTO msgs(title, category, description, source, datetime)
					VALUES($title, $category, $description, $source, $dt)";
		//var_dump($sql); die();
		$ret = $this->_db->exec($sql);
		if(!$ret)
			return false;
		return true;

	}


	protected function db2Arr($data){
		$arr = array();
		//while($row = $data->fetchArray(SQLITE3_ASSOC))
		//PDO
		while($row = $data->fetch(PDO::FETCH_ASSOC))

		$arr[] = $row;
		return $arr;
	}
	public function getNews(){
		try{
			$sql = "SELECT msgs.id as id, title, category.name as category, description, source, datetime 
					FROM msgs, category
					WHERE category.id = msgs.category
					ORDER BY msgs.id DESC";
			$result = $this->_db->query($sql);
			/*if (!is_object($result))
				throw new Exception($this->_db->lastErrorMsg());*/
			//PDO
			if (($result===false)) die('ERROR');
			//Изменение логики метода класса
			return $this->db2Arr($result);
			$fetchFunction = function() use ($result){
				//return $result-> fetchArray(SQLITE3_ASSOC);
				return $result-> fetch(PDO::FETCH_ASSOC);

			};
			return new fetchIterator($fetchFunction);
		//}catch(Exception $e){
		}catch(PDOException $e){
			return false;
		}
	}
	public function deleteNews($id){
		try{
			$sql = "DELETE FROM msgs WHERE id = $id";
			//PDO
			$result = $this->_db->exec($sql);
			/*if (!$result)
				throw new Exception($this->_db->lastErrorMsg());
			return true;*/
			if($result===false)
				die('ERROR');
		//}catch(Exception $e){
		}catch(PDOException $e){
			echo "Удаление не удалось :". $e->getMessage();
			//return false;
		}
	}
	function clearData($data){
		//return $this->_db->escapeString($data);
		//PDO
		return $this->_db->quote($data);
	}
}
?>