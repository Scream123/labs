<?php
    //���������� ������
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
    //��������� ����� ����� � ������� catalog
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
    //������������ ������ � ������
    function db2Array($data){
        $arr= array();
        while($row = mysql_fetch_assoc($data)){
            $arr[] = $row;
        }
        return $arr;
    }
    //�������������� ����� ����������� �������� �������
    function selectAll(){
            $sql = "SELECT * FROM catalog";
            $result = mysql_query($sql) or die(mysql_error());
            return db2Array($result);
    }
    //���������� ������� � �������
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
   //��������� ��� ���������������� �������
   function myBasket(){
        $sql = "SELECT author, title, pubyear, price, basket.id, goodsid, customer, quantity
                FROM catalog, basket WHERE customer = '".session_id()."' AND catalog.id = basket.goodsid";
        $result = mysql_query($sql) or die(mysql_error());
        return db2Array($result);
   }
    //�������� ������ �� �������
    function basketDel($id){
    $sql = "DELETE FROM basket WHERE id = $id";
     $result = mysql_query($sql) or die(mysql_error());
    }
    //�������������� ������� �� ������� ������� basket) � ������ (������� orders)
    function resave($datetime){
        $goods = myBasket();
        foreach($goods as $item){
    //SQL - ������, ������� �������� ������ �� ������� � ������� orders
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
        //SQL - ������, ��� �������� ������ � ������� �������� ���������� �� ������� basket
        $sql = "DELETE  FROM basket WHERE customer = '".session_id()."' ";
       mysql_query($sql) or die(mysql_error());

    }
    //��������� ���������� � �������
    function getOrders()
    {
        //�������� ����� �� �������������
        if (!file_exists(ORDERS_LOG))
            return false;
        //�������� ���������� ��� ���� �������
        $allorders = array();
        // ������ $orders ������ � ������������� �� ����� "orders.log"
        $orders = file(ORDERS_LOG);
        //��������� ���� �������
        foreach ($orders as $order){
            //���������� ���������� �� ������ �������� ������� �������
            list($name, $email, $phone, $address, $customer, $datetime) = explode("|", $order);
            //�������� ���������� � ������ ���������� ������
            $orderinfo =array();
                //���������� �������
                $orderinfo["name"] = $name;
                $orderinfo["email"] = $email;
                $orderinfo["phone"] = $phone;
                $orderinfo["address"] = $address;
                $orderinfo["datetime"] = $datetime*1;
         //SQL-������ ��� ������� �� ������� ������� ���� ������� ��� ����������� ����������
         $sql = "SELECT * FROM orders where customer ='$customer' AND datetime =" .$orderinfo["datetime"];
        //��������� ����� ���������� ���� �������
         $result = mysql_query($sql) or die(mysql_error());
//���������� ����������� � ���������� ������ ���������� ��� �������� ����� "goods" � ������� $orderinfo
         $orderinfo["goods"] =  db2Array($result);

//���������� ���������� � ������������ �� ������� $orders(name, email, phone, address, customer, date) � ������ $orderinfo
            $allorders[] = $orderinfo;


        }
//���������� ������ $allorders � ����������� � ���� ����������� � ��������� ��� �������
        return $allorders;
    }


	/*
	������� 7

    -���������� ���������������� ������� $orderinfo � ���� �������� ���������� ����� ������� $allorders
	- �������� �������������� ������ $orderinfo � ���� �������� ���������� ����� ������� $allorders
	- ������� getOrders() ������ ���������� ������ $allorders � ����������� � ���� �����������
		� ��������� ��� �������
	*/

?>