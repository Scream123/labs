<?php
switch($_POST['action']){
	case 'order':
		$titles = $_POST['order'];
		foreach($titles as $title){
			$dvd = new DVD($title);
			$dvd->buy();
		}
		break;
	case 'anthology':
		$band = trim(strip_tags($_POST['band']));
		//проверка бвл ли отправлен HTTP-методом POST
		$type = ((int)($_POST['bonus'])) ? 'bonus' : '';
		$tracks = array_map(function($val){return (int)$val;}, $_POST['order']);
		//$dvd = new DVD();
		//в переменной создаем экземпляр класса класса DVD
		$dvd = DVDFactory::create($type);
		$dvd->setBand($band);
		foreach ($tracks as $track) {
		$dvd->addTrack($track);
		}
		break;
	case 'list':
		$id = abs((int)$_POST['id']);
		//проверка бвл ли отправлен HTTP-методом POST
		$type = ((int)$_POST['format']);
		$band = trim(strip_tags($_POST['band']));
		$title = trim(strip_tags($_POST['title']));
		//$dvd = new DVD();
		//в переменной создаем экземпляр класса класса DVDasJSON
		$dvd = new DVDStrategy();
		if($type)
		$dvd-> setStrategy(new DVDAsJSON($id));
		else
		$dvd-> setStrategy(new DVDAsXML($id));
		$dvd->setTitle($title);
		$dvd->setBand($band);
		$dvd->get();
		//$dvd->getXML($id);
		break;
}
header('Location: catalog.php');
exit;
?>