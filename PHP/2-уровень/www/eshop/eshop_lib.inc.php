<?php
    //фильтрация данных
    function clearData($data, $type="s"){
        switch($type){
            case "s":
                return mysql_real_escape_string(trim(strip_tags($data)));
            case "sf":
                return trim(strip_tags($data));

            case "i":
                return (int) $data;
        }
    }
    //сохраняет новый товар в таблицу catalog
    function save($author, $title, $pubyear, $price){
        $sql = "INSERT INTO catalog(
                                author,
                                title,
                                pubyear,
                                price)
                             VALUES(
                               '$author',
                               '$title',
                               $pubyear,
                               $price)";
        mysql_query($sql) or die(mysql_error());
    }
    //Конвертируем данные в массив
    function db2Array($data){
        $arr= array();
        while($row = mysql_fetch_assoc($data)){
            $arr[] = $row;
        }
        return $arr;
    }
    //возвращающение всего содержимого каталога товаров
    function selectAll(){
            $sql = "SELECT * FROM catalog";
            $result = mysql_query($sql) or die(mysql_error());
            return db2Array($result);
    }
    //добавление товаров в корзину
    function add2basket($customer, $goodsid, $quantity, $datetime){
        $sql = "INSERT INTO basket(
                                customer,
                                goodsid,
                                quantity,
                                datetime)
	                        VALUES(
                             '$customer',
                              $goodsid,
                              $quantity,
                              $datetime)";
        mysql_query($sql) or die(mysql_error());
    }
   //озвращает всю пользовательскую корзину
   function myBasket(){
        $sql = "SELECT author, title, pubyear, price, basket.id, goodsid, customer, quantity
                FROM catalog, basket WHERE customer = '".session_id()."' AND catalog.id = basket.goodsid";
        $result = mysql_query($sql) or die(mysql_error());
        return db2Array($result);
   }
    //удаление товара из корзины
    function basketDel($id){
    $sql = "DELETE FROM basket WHERE id = $id";
     $result = mysql_query($sql) or die(mysql_error());
    }
    //пересохранение товаров из корзины таблица basket) в заказы (таблица orders)
    function resave($datetime){
        $goods = myBasket();
        foreach($goods as $item){
    //SQL - запрос, который вставлет данные из корзины в таблицу orders
        $sql = "INSERT INTO orders(
                              author,
                              title,
                              pubyear,
                              price,
                              customer,
                              quantity,
                              datetime)
                            VALUES(
                              '{$item["author"]}',
                              '{$item["title"]}',
                              '{$item["pubyear"]}',
                              '{$item["price"]}',
                              '{$item["customer"]}',
                              '{$item["quantity"]}',
                              $datetime)";
          mysql_query($sql) or die(mysql_error());
        }
        //SQL - запрос, для удаления данных о корзине текущего покупателя из таблицы basket
        $sql = "DELETE  FROM basket WHERE customer = '".session_id()."' ";
       mysql_query($sql) or die(mysql_error());

    }
    //получение информации о заказах
    function getOrders()
    {
        //проверка файла на существование
        if (!file_exists(ORDERS_LOG))
            return false;
        //хранение информации обо всех заказах
        $allorders = array();
        // массив $orders данных о пользователях из файла "orders.log"
        $orders = file(ORDERS_LOG);
        //переборка всех заказов
        foreach ($orders as $order){
            //рисваиваем переменным из списка значения подобно массиву
            list($name, $email, $phone, $address, $customer, $datetime) = explode("|", $order);
            //хранение информации о каждом конкретном заказе
            $orderinfo =array();
                //заполнение массива
                $orderinfo["name"] = $name;
                $orderinfo["email"] = $email;
                $orderinfo["phone"] = $phone;
                $orderinfo["address"] = $address;
                $orderinfo["datetime"] = $datetime*1;
         //SQL-запрос для выборки из таблицы заказов всех товаров для конкретного покупателя
         $sql = "SELECT * FROM orders where customer ='$customer' AND datetime =" .$orderinfo["datetime"];
        //Получение всего результата этой выборки
         $result = mysql_query($sql) or die(mysql_error());
//Сохранение полученного в предыдущем пункте результата как значение ключа "goods" в массиве $orderinfo
         $orderinfo["goods"] =  db2Array($result);

//Сохранение информации о пользователе из массива $orders(name, email, phone, address, customer, date) в массив $orderinfo
            $allorders[] = $orderinfo;


        }
//возвращает массив $allorders с информацией о всех покупателях и сделанных ими заказах
        return $allorders;
    }


	/*
	ЗАДАНИЕ 7

    -Добавление сформированнного массива $orderinfo в виде значения очередного ключа массива $allorders
	- Добавьте сформированный массив $orderinfo в виде значения очередного ключа массива $allorders
	- Функция getOrders() должна возвращать массив $allorders с информацией о всех покупателях
		и сделанных ими заказах
	*/

?>