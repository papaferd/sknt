<?php
defined('BASES') OR exit('No direct script access allowed');

/**
 * GetTarifs - Получвем тариф, данный преобразуем в массив
 */


class GetTarifs extends datamysql{

var $query;	
var $jjson;
	
	function __construct(array $data) {	
		
		datamysql::__construct();		
		$this->query = '
		SELECT u.id as uID, 
		t2.id as Tid, t2.title as Ttitle, t2.price as Tprice, t2.link as Tlink, t2.speed as Tspeed, t2.pay_period as Tpayperiod,
		t.id as id, t.title as title, t.price as price, t.link as link, t.speed as speed, t.pay_period as payperiod
		FROM tarifs as t 
		LEFT JOIN users u ON u.ID='.$data['users'].'
		LEFT JOIN services s ON s.user_id='.$data['users'].'
		LEFT JOIN tarifs as t2 ON s.tarif_id=t2.id
		WHERE t.tarif_group_id='.$data['services'];
		$this->jsonarrayGetTarifs($this->getdata($this->query));
	
   	}
	
	
	private function jsonarrayGetTarifs($query_list){
		$this->jjson = array();
		
		//Разбираем массив и преобразуем его для вывода в JSON	

		if(isset($query_list[0]['uID'])){
			
			foreach($query_list as $k=>$v){

				if(!isset($this->jjson['tarifs'][0]['title']) && !isset($v['Ttitle']))$this->jjson['tarifs'][0]['title'] = $v['Ttitle'];
				if(!isset($this->jjson['tarifs'][0]['link']) && !isset($v['Tlink']))$this->jjson['tarifs'][0]['link'] = ($v['Tlink']);
				if(!isset($this->jjson['tarifs'][0]['speed']) && !isset($v['Tspeed']))$this->jjson['tarifs'][0]['speed'] = $v['Tspeed'];

				$this->jjson['tarifs'][0]['tarifs'][$v['id']]['ID'] = $v['id'];
				$this->jjson['tarifs'][0]['tarifs'][$v['id']]['title'] = $v['title'];
				$this->jjson['tarifs'][0]['tarifs'][$v['id']]['price'] = $v['price'];
				$this->jjson['tarifs'][0]['tarifs'][$v['id']]['pay_period'] = $v['payperiod'];
				$this->jjson['tarifs'][0]['tarifs'][$v['id']]['new_payday'] = strtotime('today midnight + '.$v['payperiod'].' month').''.date('O');// текущая дата полночь + pay_period + смещение
				$this->jjson['tarifs'][0]['tarifs'][$v['id']]['speed'] = $v['speed'];
			}
		}					
	}
}
