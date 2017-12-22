<?php

class Router {
    //св-ва массива для хранекния маршрутов
    private $routes;

    public function __construct() {
        //путь к роутам
        $routesPath = ROOT . '/config/routes.php';
        $this -> routes = include($routesPath);

    }
    /**
     * метод аозвращает строку
     * @return string
     */
    private  function getURI() {
        if (!empty($_SERVER['REQUEST_URI'])) {
           return trim($_SERVER['REQUEST_URI'],'/');
        }
    
    }
    //принимает управление от FRONT CONTROLLER
    public function run() {

        //получть строку запроса
        $uri = $this->getURI();

        //Проверить наличие такого запроса в routes.php
        foreach ($this -> routes as $uriPattern => $path) {

            //Сравнениванием $uriPattern и $uri
            if (preg_match("~$uriPattern~", $uri)) {
//                echo "<br>Где ищем (запрос, который набрал пользователь): ".$uri;
//                echo "<br>Что ищем (совпадение из правила): ".$uriPattern;
//                echo "<br>Кто обрабатывает: ".$path;


                // Получаем внутренний путь из внешнего согласно правилу.
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
//                echo '<br>Нужно сформировать: ' .$internalRoute. '<br>';

                //Определить какой контроллер и action обрабатывает запрос
                $segments = explode('/', $internalRoute);
               $controllerName = array_shift($segments).'Controller';
               $controllerName = ucfirst($controllerName);

                $actionName = 'action' . ucfirst(array_shift($segments));

//                echo '<br>controller name: ' . $controllerName;
//                echo '<br>action name: ' . $actionName;
                $parameters = $segments;
                /*echo '<pre>';
                print_r($parameters);
                die;*/

                //Подключить файл класса-контроллера
                $controllerFile = ROOT . '/controllers/' .$controllerName. '.php';

                if (file_exists($controllerFile)) {
                    include_once ($controllerFile);
                        }

                            //Создать объект, вызвать метод(т.е. action)
                            $controllerObject = new $controllerName;

                            $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                            if ($result != null) {
                        break;
                    }




            }
        }
    }
}