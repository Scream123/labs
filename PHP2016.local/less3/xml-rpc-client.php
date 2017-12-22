<?php
header('Content-Type: text/html;charset=utf-8');

//лаба№5
//Создание универсальной функции открытия сокета
function call_socket($remote_server, $remote_server_port, $remote_path, $request) {
    $sock = fsockopen($remote_server, $remote_server_port, $errno, $errstr, 30);

    if (!$sock) die("$errstr($errno)\n");

    $out = "POST $remote_path HTTP/1.1\r\n";
    $out .= "User-Agent: PHPRPC/1.0\r\n";
    $out .= "Host: $remote_server\r\n";
    $out .= "Content-type: text/xml\r\n";
    $out .= "Content-length: " .strlen($request)."\r\n";
    $out .= "Accept: */*\r\n\r\n";
    $out .= "$request\r\n\r\n";
    fputs($sock, $out);

    $headers = "";
    while ($str = trim(fgets($sock, 4096)));
    $headers .= "$str\n";
    $data = "";
    while (!feof($sock))
        $data .= fgets($sock,4096);
    fclose($sock);
    return $data;

}




//лаба 4.2
/* Сюда приходят данные с сервера */
$output = [];

/* Основная функция */
function make_request($request_xml, &$output) {

    // лаба№5
    $retval = call_socket('lessonsPHP2016.local', 80, '/less3/xml-rpc/xml-rpc-server.php', $request_xml);

    //лаба №4.2
    /* НАЧАЛО ЗАПРОСА */
    /*
    $options = [ 'http'=>[
        'method' => "POST",
        'header' => "User-Agent: PHPRPC/1.0\r\n" .
            "Content-Type: text/xml\r\n" .
            "Content-length: " . strlen($xml) . "\r\n",
        'content' => "$xml"
        ]
    ];
    $context = stream_context_create($options);
    $retval = file_get_contents('http://lessonsphp2016.local/less3/xml-rpc/xml-rpc-server.php', false, $context);
*/
    /* КОНЕЦ ЗАПРОСА */
    $data = xmlrpc_decode($retval);
    if (is_array($data) && xmlrpc_is_fault($data)){
        $output = $data;
    }else{
        $output = unserialize(base64_decode($data));
    }
}
/* Идентификатор статьи */
$id = 5;
$request_xml = xmlrpc_encode_request('getNewsById', array($id));
make_request($request_xml, $output);

/* Вывод результата */
var_dump($output);
?>