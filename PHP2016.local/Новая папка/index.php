<?php
spl_autoload_register(function($class){
	echo str_replace("\\", "/", __DIR__."\\".$class).".php";
	include __DIR__."/".str_replace("\\", "/", $class).".php";
});

new classes\classmain();