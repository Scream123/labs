<?php
//хранение маршрутов
return array(

    'news/([0-9]+)' => 'news/view/$1',//actionIndex в NewsController
    'news' => 'news/index', //actionIndex в ProductController
  //'products' => 'product/list',
);