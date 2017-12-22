<?php
function dirs($dir,$tab){
    $d = opendir($dir);
    while ($name = readdir($d)) {
        if ($name == "." or $name == "..")
            continue;
        if (is_dir($name)) {
            echo "<b>".$tab."[$name]</b><br>";
            $tab = '-';
            dirs($dir . "/$name",$tab);
        }else
            echo "$tab$name<br>";
    }
    closedir($d);
}
    dirs(".","");
