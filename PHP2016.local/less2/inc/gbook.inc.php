<?php
//лаба №8
/* Основные настройки */
define('DB_HOST', 'localhost');
define('DB_LOGIN', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'gbook');

$conn = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die("Ошибка подключения!");

/* Основные настройки */

/* Сохранение записи в БД */
function clearData($data, $type ='s'){
    switch($type) {
        case "s":
            $data = trim(strip_tags($data));
            
            break;
        case "i":
            $data = abs((int)$data);
            break;
    }
    return $data;
}
if ($_SERVER['REQUEST_METHOD']=='POST'){

    $name = clearData($_POST['name']);
    $name = mysqli_real_escape_string($conn, $name);
    $email =  clearData($_POST['email']);
    $msg =  clearData($_POST['msg']);
//формируем SQL оператор
    $sql ="INSERT INTO msgs(`name`, email, msg)
					   VALUES('$name','$email','$msg')";

    $res = mysqli_query($conn,$sql) or die(mysqli_error($conn));

    //header('Location:'.$_SERVER['REQUEST_URI']);
   // exit;

}


/* Сохранение записи в БД */

/* Удаление записи из БД */
if (isset($_GET['del'])) {
    $del = clearData($_GET['del'],'i');
    if ($del>0) {
        $sql = "DELETE FROM msgs WHERE id = $del";
        $res = mysqli_query($conn,$sql) or die(mysqli_error($conn));

    }
}
/* Удаление записи из БД */
?>
<h3>Оставьте запись в нашей Гостевой книге</h3>

<form method="post" action="<?= $_SERVER['REQUEST_URI']?>">
Имя: <br /><input type="text" name="name" /><br />
Email: <br /><input type="text" name="email" /><br />
Сообщение: <br /><textarea name="msg"></textarea><br />

<br />

<input type="submit" value="Отправить!" />

</form>
<?php
/* Вывод записей из БД */
$sql =" SELECT id, name, email, msg
            FROM msgs ORDER BY id DESC";

$users = mysqli_query($conn,$sql) or die(mysqli_error($conn));

echo "<p>Всего записей в гостевой книге:" .mysqli_num_rows($users). "</p>";
mysqli_close($conn);

while($user =  mysqli_fetch_assoc($users)) {
    $msg = nl2br($user["msg"]);
    $t = time();
    $dt = date("d-m-Y H:i:s",$t);
?>
    <hr>
    <p><a href="mailto:<?=$user['email']?>"><?=$user['name']?></a>

    <?=$dt?><br/><?=$msg;?>
    </p>
    <p align="right">
        <a href="index.php?id=gbook&del=<?=$user['id'] ?>">Удалить</a>
    </p>
<?php
}

/* Вывод записей из БД */
?>