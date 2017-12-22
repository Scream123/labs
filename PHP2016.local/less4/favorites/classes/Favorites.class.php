<?
class Favorites{
  private $plugins = [];

  //лаба№4
  //Подключение всех классов
  function __construct(){
    $isExist = false;
        $classInfo = glob('classes/*/*.class.php');
        foreach ($classInfo as $class) {
          if (is_file($class))
          include_once "$class";
          $isExist = true;
        }
    if ($isExist)$this->findPlugins();
  }
	//выбирает только те классы, которые наследуют интерфейс IPlugin
  private function findPlugins() {
    $classes = get_declared_classes();


    //if ($classes == true){
      foreach ($classes as $class) {
        $rc = new ReflectionClass($class);
        if ($rc-> implementsInterface('IPlugin')) //{
          $this->plugins[] = $rc;
        //}
      }
    //}
  }
	
  function getFavorites($methodName) {
    //проверка
    $list = [];
    $items = [];

      foreach ($this->plugins as $rc) {
        //имеет ли класс тот или иной метод
        if ($rc->hasMethod($methodName)) {
            //забираем этот метод
            $rm = $rc->getMethod($methodName);
        //проверка статический ли он
        if($rm->isStatic()){
          $items = $rm->invoke(null);//Для статических методов передается null.
        }else{
          $items = $rm->invoke($rc->newInstance()); //для обычного метода создаем объект
          $list[] = $items;
        }
      }
      
      }
    return $list; //возвращает массив с результатами отработанных методов
  }
}
