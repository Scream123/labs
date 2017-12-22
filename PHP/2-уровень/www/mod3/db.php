<?php

 mysql_connect ("localhost", "root", "");
    mysql_select_db("web") or die(mysql_error());
    mysql_query("SET NAMES 'cp1251'") or die(mysql_error());
    $sql = "SELECT * FROM teachers";
    $result = mysql_query($sql);
    mysql_close();
    echo "<p>Всего записей: " .mysql_num_rows($result) . '<p>';
    while($row = mysql_fetch_assoc($result)){
    echo $row["name"] . "<br>";
}
//echo "<pre>";print_r($row);echo "</pre>";