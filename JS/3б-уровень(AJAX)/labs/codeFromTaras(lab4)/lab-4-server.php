<?php
// Способы доставки
$deliveryMethods = array
(
	0 => 'Без доставки',
	1 => 'Доставка курьером',
	2 => 'Доставка почтой',
	3 => 'Доставка UPS',
	4 => 'Доставка Fedex'
);

// Стоимость доставки
$deliveryCost = array
(
	0 => 0,
	1 => 200,
	2 => 160,
	3 => 450,
	4 => 500
);

// Налоги и сборы, в %
$taxes = array
(
	'НДС' => 18,
	'Налог с продаж' => 5,
	'Обработка заказа' => 10
);


// XML-PRC сервер
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
require('xmlrpc.php');

// Включим отладку
define('XMLRPC_DEBUG', true);

// Декларация методов и назначение методам функций 
$xmlrpc_methods = array
(
	'eshop.getDeliveryMethods' => 'getDeliveryMethods',
	'eshop.calculateOrder' => 'calculateOrder'
);

// Обработка запроса
// $xmlrpc_request = XMLRPC_parse($HTTP_RAW_POST_DATA);
// $methodName = XMLRPC_getMethodName($xmlrpc_request);
// $params = XMLRPC_getParams($xmlrpc_request);
// var_dump($methodName); die();
// if(isset($xmlrpc_methods[$methodName])){
//     // Вызов метода
//     $result = $xmlrpc_methods[$methodName]($params); 
// 	XMLRPC_response(XMLRPC_prepare($result), WEBLOG_XMLRPC_USERAGENT);
// }else{
// 	// Ошибка: Нет такого метода
// 	XMLRPC_error('2', "Метод '$methodName' не найден.", WEBLOG_XMLRPC_USERAGENT);
// }

$xmlrpc_server_handler = xmlrpc_server_create();
xmlrpc_server_register_method($xmlrpc_server_handler, "eshop.getDeliveryMethods", "getDeliveryMethods");

// Creating XML return data
if ($response = xmlrpc_server_call_method($xmlrpc_server_handler, $HTTP_RAW_POST_DATA, null, array('encoding' => 'UTF-8'))) {
	header('Content-Type: text/xml; charset=utf-8');
	echo iconv('iso-8859-1', 'UTF-8', $response);
}
// ----------------------------- Бизнес - логика -----------------------------

// Функция возвращает методы доставки
function getDeliveryMethods($params){
	global $deliveryMethods;
	return $deliveryMethods;
}

// Функция возвращает расчет стоимости заказа
function calculateOrder($params){
	global $deliveryMethods, $deliveryCost, $taxes;
	
	// Параметры
	$sum = $params[0];
	$deviveryId = $params[1];
	
	// Расчет заказа
	$result = array();
	$result['Стоимость заказа'] = (float) $sum;
	$result[$deliveryMethods[$deviveryId]] = (float) $deliveryCost[$deviveryId];
	foreach ($taxes as $taxName => $taxValue){
		$taxSum = $sum * ($taxValue / 100);
		$result[$taxName] = (float) $taxSum;
	}
	return $result;
}

// ----------------------------- Отладка -----------------------------

// Запись отладочной информации
if(defined('XMLRPC_DEBUG') and XMLRPC_DEBUG){
	$logFileName = 'debug/' . date('Ymd-His') . '.log';
	if($GLOBALS['XMLRPC_DEBUG_INFO']){
		$defugInfo = '';
		$newLine = "\r\n";
		foreach($GLOBALS['XMLRPC_DEBUG_INFO'] as $debug)
			$defugInfo .= $debug[0] . ': ' . $debug[1] . $newLine;
		$defugInfo .= $newLine;
		@ file_put_contents($logFileName, str_replace("\n", "\r\n", $defugInfo));
	}
}
?>