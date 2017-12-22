<?
if (is_file("log/".PATH_LOG)){
    $file = file("log/".PATH_LOG);
    echo "<ol>";
    foreach($file as $line) {
        list($dt, $page,$ref) = explode("|", $line);
        echo <<<OUT
        <li>
        [$dt]: $ref -> $page
        </li>
OUT;
    }
    echo "</ol>";
}
