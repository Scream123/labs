<?php
	// Создание SOAP-клиента
    $client = new SoapClient("http://specialistphplevel333.local/www/soap/stock.wsdl");
//var_dump($client->__getFunctions());
//try{
    // Послание SOAP-запроса c получением результата
    $result = $client->getStock("2");
    echo $result;
    //}catch(SoapFault $e){echo $e->getMessage();}

?>