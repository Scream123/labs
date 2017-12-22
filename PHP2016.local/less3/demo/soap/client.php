<?php
try {
  // Создание SOAP-клиента
  //echo $_SERVER['HTTP_REFERER'];
  $client = new SoapClient("http://lessonsPHP2016.local/less3/demo/soap/stock.wsdl");

  // Посылка SOAP-запроса c получением результат
  $result = $client->getStock("1");
  echo "Текущий запас на складе: ", $result;
} catch (SoapFault $exception) {
 echo $exception->getMessage();
}
?>