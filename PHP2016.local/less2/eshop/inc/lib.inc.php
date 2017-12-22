<?php
//Библиотека функций сайта

//Сохранение данных каталога
function addItemToCatalog($title, $author, $pubyear, $price) {

    global $conn;
    $sql = "INSERT INTO catalog(title, author, pubyear, price)
                   VALUES(?,?, ?, ?)";

    if (!$stmt = mysqli_prepare($conn, $sql))
        return false;
    mysqli_stmt_bind_param($stmt, "ssii",
                           $title, $author,
                           $pubyear, $price);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return true;
}
    //Фильтрация данных из формы
    function clearData($data, $type = 's') {
        global $conn;
        switch ($type) {
            case 's':
                $data = mysqli_real_escape_string($conn, trim(strip_tags($data)));
                break;
            case 'i':
                $data = abs((int)$data);
                break;
        }
        return $data;
    }

//Выборка и показ товаров из каталога
function selectAllItems() {
    global $conn;
    $sql = 'SELECT id, title, author, pubyear, price FROM catalog';
    if (!$result = mysqli_query($conn, $sql))
        return false;
    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    return $items;
}

//Сохранение товара в корзину пользователя
function saveBasket() {
    global $basket;
    $basket = base64_encode(serialize($basket));
    setcookie('basket', $basket, 0x7FFFFFFF);
}

//Создает либо загружает в переменную $basket в корзину с товарами, либо создает новую корзину с идентификатором заказа
function basketInit() {
    global $basket, $count;
    if(!isset($_COOKIE['basket'])){
        $basket = ['orderid' => uniqid()];
        saveBasket();
    }else{
        $basket = unserialize(base64_decode($_COOKIE['basket']));
        $count = count($basket) -1;
    }
}

//добавляет товар в корзину пользователя и принимает в качестве аргумента идентификатор товара
function add2Basket($id) {
    global $basket;
    $basket[$id] = 1;
    saveBasket();
}

//принимает результат выполнения функции myBasket и возвращает ассоциативный массив товаров, дополненный их количеством
function result2Array($data) {
    global $basket;
    $arr = [];
    while($row = mysqli_fetch_assoc($data)) {
        $row['quantity'] = $basket[$row['id']];
        $arr[] = $row;
    }
    return $arr;
}

//Возвращает всю пользовательскую корзину в виде ассоциативного массива
 function myBasket() {
     global $conn, $basket;
     //выбираем массив ключей
     $goods = array_keys($basket);
     //Извлекаем первый элемент массива
     array_shift($goods);
     if(!$goods) return false;
     $ids = implode(",", $goods);
     $sql = "SELECT id, `author`, `title`, `pubyear`, `price` FROM catalog WHERE id IN ($ids)";
     if(!$result = mysqli_query($conn, $sql))
         return false;
     $items = result2Array($result);
     mysqli_free_result($result);
    return $items;
 }

//Удаление товара из корзины
function deleteItemFromBasket($id) {
    global $basket;
    unset($basket[$id]);
    saveBasket();
}

//Пересохраняет товары из корзины в таблицу базы данных orders
// и принимает в качестве аргумента дату и время заказав виде временной метки
function saveOrder($datetime){

    global $conn, $basket;
    $goods = myBasket();

    $stmt = mysqli_stmt_init($conn);
    $sql = "INSERT INTO orders ( 
                                title, 
                                author, 
                                pubyear,
                                price, 
                                quantity, 
                                orderid,
                                datetime)
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    if (!mysqli_stmt_prepare($stmt, $sql))
        return false;
    foreach($goods as $item){
        mysqli_stmt_bind_param($stmt, "ssiiisi",
            $item['title'], $item['author'],
            $item['pubyear'], $item['price'],
            $item['quantity'], $basket['orderid'],
            $datetime);
        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);
    //Удаление куки
    setcookie('basket','', 1);
    return true;
}

//возвращает многомерный массив с информацией о всех заказах,
// включая персональные данные покупателя и список его товаров
function getOrders() {

    global $conn;
    if(!is_file(ORDERS_LOG))
        return false;
    /* Получаем в виде массива персональные данные пользователей из файла */
    $orders = file(ORDERS_LOG);

    /* Массив, который будет возвращен функцией */
    $allorders = [];

    foreach ($orders as $order) {
        list($name, $email, $phone, $address,$date, $orderid) = explode("|", trim($order));

        /* Промежуточный массив для хранения информации о конкретном заказе */
        $orderinfo = [];

        /* Сохранение информацию о конкретном пользователе */
        $orderinfo["name"] = $name;
        $orderinfo["email"] = $email;
        $orderinfo["phone"] = $phone;
        $orderinfo["address"] = $address;
        $orderinfo["orderid"] = $orderid;
        $orderinfo["date"] = $date;

        /* SQL-запрос на выборку из таблицы orders всех товаров для конкретного покупателя */
        $sql = "SELECT title, author, pubyear, price, quantity
                  FROM orders WHERE orderid = '$orderid'";

        /* Получение результата выборки */
        if(!$result = mysqli_query($conn, $sql))
            return false;

        $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);

        /* Сохранение результата в промежуточном массиве */
        $orderinfo["goods"] = $items;
        

        /* Добавление промежуточного массива в возвращаемый массив */
        $allorders[] = $orderinfo;
    }
    return $allorders;
}







 