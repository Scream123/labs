<?php
    //если добавить класс:
    class   StockService
    {

        // Описать функцию/метод Web-сервиса
        function getStock($num)
        {
            $stock = array(
                "1" => 100,
                "2" => 200,
                "3" => 300,
                "4" => 400,
                "5" => 500);
            if (array_key_exists($num, $stock))
                return $stock[$num];
            else
                return 0;
            //throw new SoapFault("Server","NO GOODS!");
        }
    }
    //echo getStock("2");
	// Отключить кэширование WSDL-документа(только для веб-разработки,для запуска сервера нужно отключить)
    ini_set("soap.wsdl_cache_enabled","0");
	// Создать SOAP-сервер
$server = new SoapServer("http://specialistphplevel333.local/www/soap/stock.wsdl");
    //если добавить два массива:
    //$arr = array("foo1","foo2");
    //$server->addFunction("arr");
    //или добавить класс к серверу
    //$server->setClass("StockService");
        // Добавить функцию/класс к серверу
        $server->addFunction("getStock");


	// Запуск сервера
//var_dump($server->getFunctions());
	$server-> handle();
?>