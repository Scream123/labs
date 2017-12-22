//функция с помощью которой можно делать HTTP-запросы к серверу без перезагрузки страницы на любой версии браузера
//функция возвращает объект  XmlHttpRequest
function getXmlHttpRequest(){
//если есть то это не IE(7)
	if(window.XMLHttpRequest){
	try{ return new XMLHttpRequest();}
	catch(e){}
	}else if(window.ActiveXObject){
	try{ return new ActiveXObject("Msxml2.XMLHTTP");}
	catch(e){}
	try{ return new ActiveXObject("Microsoft.XMLHTTP");}
	catch(e){}
	}
	return null;//1% на то , что нам не повезло,делаем ретурн
}  