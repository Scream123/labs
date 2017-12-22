<?
class Favorites{
	private $_plugins = array();
	
	function __construct(){
		$isExist = false;
		foreach (glob("classes/*/*.class.php") as $item){
			if(is_file($item)){
				include_once($item);
				$isExist = true;
			}
		}
			if($isExist) $this ->findPlugins();
	}

	private function findPlugins() {
				//выборка классов,которые наследуют интерфейс IPlugin
		$classes = get_declared_classes();
		if($classes == true) {
			foreach ($classes as $className) {
				$rc = new ReflectionClass($className);
				if ($rc-> implementsInterface('IPlugin')){
					$this->_plugins[]=$rc;
				}

			}
		}
	}
		function getFavorites($methodName){
			//проверка
				$list=[];
				$items = [];
				foreach ($this->_plugins as $rc) {
					//имеет ли класс тот или иной метод
					if ($rc->hasMethod($methodName)){
						//забираем этот метод
						$rm = $rc->getMethod($methodName);
						//проверка статический ли он
						if ($rm->isStatic()) {
							$items = $rm->invoke(null); //Для статических методов передается null.
						} else {
							$items = $rm->invoke($rc->newInstance());//для обычного метода создаем объект
						}
					}
					$list[] = $items;

				}
			return $list;//возвращает массив с результатами отработанных методов

		}


}


?>

