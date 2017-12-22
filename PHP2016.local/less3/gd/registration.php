<?php

//лаба№6
session_start();

$result = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST'){


  if (isset($_SESSION['randStr']) && $_SESSION['randStr'] == strtolower($_POST['answer'])){

    $result = 'Хорошо';
  }else{
    $result = 'Плохо';

  }
  if (!isset($_SESSION['randStr'])) {

    $result = 'ВКЛЮЧИ ГРАФИКУ!';
  }
}
?>
<!DOCTYPE HTML>
<html>

<head>
  <meta charset="utf-8" />
  <title>Регистрация</title>
</head>

<body>
  <h1>Регистрация</h1>
  <form action="" method="post">
    <div>
      <img src="noise-picture.php">
    </div>
    <div>
      <label>Введите строку</label>
      <input type="text" name="answer" size="6">
    </div>
    <input type="submit" value="Подтвердить">
  </form>
<?php
echo $result;
?>
  <?php

  ?>

</body>
</html>