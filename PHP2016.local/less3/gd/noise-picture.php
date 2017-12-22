<?php
//лаба№6

session_start();
//Создание изображения для jpeg
$img = imagecreatefromjpeg('images/noise.jpg');

//цвет для рисования
$color = imagecolorallocate($img,64, 64, 64);

//Сглаживание(ухудшает распознавание текста на картинке программным способом)
imageantialias($img, true);

//кол-во выводимых символов
$nChars = 5;

//генерация случайной строка
$randStr = substr(md5(uniqid()), 0, $nChars);

//сессионная переменная
$_SESSION['randStr'] = $randStr;

//начальные координаты для отрисовки строки
$x =20; $y = 30;

//смещение текущего символа относительно оси
$delta_X = 40;

//отрисовка строки
for ($i = 0; $i< $nChars; $i++) {
    $size = rand(16, 30);
    $angle = -30 + rand(0, 60);//угол наклона
     imagettftext($img,$size,$angle,$x, $y, $color, 'fonts/georgia.ttf',$randStr{$i});
    $x+=$delta_X;
}
header('content-Type: image/jpg');
imagejpeg($img);