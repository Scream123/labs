<?php
    //print_r($_FILES);
if ($_FILES ['uf'] ['error'] == 0){
    $t = $_FILES ['uf'] ['tmp_name'];
    $n = $_FILES ['uf'] ['name'];
    move_uploaded_file($t, "upload/".$n);
}
?>

    <form action = "files.php" method = "POST" enctype = "multipart/form-data">
    <input type = "file" name = "uf">
    <input type = "submit">
    </form>