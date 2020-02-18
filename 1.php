<?php
header('HTTP/1.0 200 OK');	
header('Content-Type: text/html; charset=utf8');


$data = array('tarif_id'=>'5');
$data_json = json_encode($data);

///Изменить имя сайта при тестировании
$url ='http://test3.ru/users/1/services/1/tarif';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_AUTOREFERER,false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/json','Content-Length: '.strlen($data_json)));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response  = curl_exec($ch);


print_r($response);
