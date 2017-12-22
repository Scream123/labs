<?
function setup($x) {
    $i = 0;
 return function() use ($x, &$i) {
     if (isset($x[$i]))
     return $x[$i++];
 };

}
$next = setup(['a','b','c']);
println( $next());
println( $next());
println( $next());
println( $next());

function println($var) {

        echo $var ."<br/>";
}
