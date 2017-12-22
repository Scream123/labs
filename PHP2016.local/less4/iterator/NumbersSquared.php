<?php
//лаба№2.1
header('Content-Type: text/plain; charset = utf-8');
class NumbersSquared implements  Iterator{
    //хранение первого числа
    private $start;
    //хранение второго числа
    private $end ;
    //хранение текущего числа
    private $current;

    function __construct($s, $e) {
        if (isset($s))
        $this->start = $s;
        if (isset($e))
            $this->end = $e;
    }

    function rewind() {
        $this->current = $this->start;
    }

    function valid() {
        // TODO: Implement valid() method.
    if ($this->current > $this->end){
           // echo "Ошибка! Число 'current': {$this->current} больше  числа 'end': $this->end.\n";
            return false;
        }else {
            return true;
        }
        //или так:
        //return $this->current <= $this->end;
    }

    function next() {
        // TODO: Implement next() meth
             $var = $this->current++;
      //  return $var;

    }

    function key() {
        // TODO: Implement key() method.
    return $this->current;
    }

    function current() {
        // TODO: Implement current() method.
        $res = pow($this->current,2);
    return $res;
    }


}

$obj = new NumbersSquared(4,7);

foreach ($obj as $num => $square) {
    echo "Квадрат числа $num = $square\n";

}







