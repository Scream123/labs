<?php
//Основной файл новостной ленты
//Описание класса
require_once 'NewsDB.class.php';

$news = new NewsDB();
$errMsg = "";

if ($_SERVER['REQUEST_METHOD']=='POST')
  include 'save_news.inc.php';

//Проверка удаления записи запроса методом GET
if (isset($_GET['id']))
  include 'delete_news.inc.php';

?>
<!DOCTYPE html>
<html>
<head>
	<title>Новостная лента</title>
	<meta charset="utf-8" />
</head>
<body>
  <h1>Последние новости</h1>
  <?php
  if ($errMsg) {
    echo $errMsg;
  }

  ?>
  <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
    Заголовок новости:<br />
    <input type="text" name="title" /><br />
    Выберите категорию:<br />
    
    
<?php
//лаба2.2(ур.4)
$iterator = $news->getIterator();

?>
    <select name="category">
<?php
      foreach ($iterator as $key => $val):

        echo "<option value='$key'>$val</option>\n";
?>
 <!--      <option value="1">Политика</option>-->
<!--      <option value="2">Культура</option>-->
<!--      <option value="3">Спорт</option>-->
      <?endforeach;?>
    </select>

    <br />
    Текст новости:<br />
    <textarea name="description" cols="50" rows="5"></textarea><br />
    Источник:<br />
    <input type="text" name="source" /><br />
    <br />
    <input type="submit" value="Добавить!" />
</form>
<?php
require_once 'get_news.inc.php';
$posts = $news->getNews();
//print_r($posts);

?>
</body>
</html>