<?php
define('BASES', 'sknt');
//Хеадеры
header('HTTP/1.0 200 OK');	
header('Content-Type: text/html; charset=utf8');

//настройки базы
include('db_cfg.php');
//Класс для вызова запросов к базе 
include('c/class_mysql.php');
$data_mysql = new datamysql();
//логирование ошибок Exception
include('c/class_log.php');

function er404($er){
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	echo 'HTTP/1.0 404 Not Found<br>'.$er;
	die;
}

function json_err(){
	$arr = array('result'=>'error');
	json($arr);
	die;
}

function json($array){
	$j = defined('JSON_UNESCAPED_UNICODE')?json_encode($array, JSON_UNESCAPED_UNICODE):json_encode($array);
	//В стареньких версиях пхп типа моей нет этой функции, если ее нет, то вывод кирилицы будет в нечитаемом виде, но все будет работать. 
	echo $j;
}

///Преобразуем строку запроса в массив
$URI = explode('/',$_SERVER['REQUEST_URI']);
unset($URI[0]);

//Простенькая обработка 404 ошибки
if($URI[count($URI)-4]!='users' or $URI[count($URI)-2]!='services'){
	er404('Неверная страница');
}

$user = htmlspecialchars($URI[count($URI)-3]);
$service = htmlspecialchars($URI[count($URI)-1]);

//Вызываем массив и сразу ему пишем статус -- ок
$JSONARRAY = array();
$JSONARRAY['result']='ok';



if($URI[count($URI)]=='tarifs'){
//Если запрашиваются тарифы	
$query = '
SELECT  
t2.id as Tid, t2.title as Ttitle, t2.price as Tprice, t2.link as Tlink, t2.speed as Tspeed, t2.pay_period as Tpayperiod,
t.id as id, t.title as title, t.price as price, t.link as link, t.speed as speed, t.pay_period as payperiod
FROM tarifs as t 
LEFT JOIN services s ON s.user_id='.$user.'
LEFT JOIN tarifs as t2 ON s.tarif_id=t2.id
WHERE t.tarif_group_id='.$service;
	
$tt = $data_mysql->getdata($query);//Выполнили запрос получили массив с данными

if(count($tt)<1)json_err();	
	

//Разбираем массив и преобразуем его для вывода в JSON	
foreach($tt as $k=>$v){
	
	if($JSONARRAY['tarifs'][0]['title']=='')$JSONARRAY['tarifs'][0]['title'] = $v['Ttitle'];
	if($JSONARRAY['tarifs'][0]['link']=='')$JSONARRAY['tarifs'][0]['link'] = $v['Tlink'];
	if($JSONARRAY['tarifs'][0]['speed']=='')$JSONARRAY['tarifs'][0]['speed'] = $v['Tspeed'];
	
	$JSONARRAY['tarifs'][0]['tarifs'][$k]['ID'] = $v['id'];
	$JSONARRAY['tarifs'][0]['tarifs'][$k]['title'] = $v['title'];
	$JSONARRAY['tarifs'][0]['tarifs'][$k]['price'] = $v['price'];
	$JSONARRAY['tarifs'][0]['tarifs'][$k]['pay_period'] = $v['payperiod'];
	$JSONARRAY['tarifs'][0]['tarifs'][$k]['new_payday'] = strtotime('today midnight + '.$v['payperiod'].' month');// текущая дата полночь + pay_perioddate("j M Y")
	$JSONARRAY['tarifs'][0]['tarifs'][$k]['speed'] = $v['speed'];
}
	
//Vмассив для JSON готов	
	
}elseif($URI[count($URI)]=='tarif'){
	//Если устанавливается тариф пользователю
	echo 'tarif';
}else{
	er404('Не верно указан метод вызова функции');
}



json($JSONARRAY);
die;
