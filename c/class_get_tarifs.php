<?php
defined('BASES') OR exit('No direct script access allowed');

class get_tarifs extends datamysql{

var $query;
var $tt;	
var $json;
	
	function __construct($data) {	
		
		datamysql::__construct();
		$this->json=array();		
		$this->query = '
		SELECT u.id as uID, 
		t2.id as Tid, t2.title as Ttitle, t2.price as Tprice, t2.link as Tlink, t2.speed as Tspeed, t2.pay_period as Tpayperiod,
		t.id as id, t.title as title, t.price as price, t.link as link, t.speed as speed, t.pay_period as payperiod
		FROM tarifs as t 
		LEFT JOIN users u ON u.ID='.$data[users].'
		LEFT JOIN services s ON s.user_id='.$data[users].'
		LEFT JOIN tarifs as t2 ON s.tarif_id=t2.id
		WHERE t.tarif_group_id='.$data[services];
		$this->tt = $this->getdata($this->query);
		$this->jsonarray_get_tarifs();
	
   	}
	
	
	private function jsonarray_get_tarifs(){
		$this->json = array();
		//Разбираем массив и преобразуем его для вывода в JSON	
		if($this->tt[0]['uID']!=''){
		foreach($this->tt as $k=>$v){

			if($this->json['tarifs'][0]['title']=='' && $v['Ttitle']!='')$this->json['tarifs'][0]['title'] = $v['Ttitle'];
			if($this->json['tarifs'][0]['link']=='' && $v['Tlink']!='')$this->json['tarifs'][0]['link'] = ($v['Tlink']);
			if($this->json['tarifs'][0]['speed']=='' && $v['Tspeed']!='')$this->json['tarifs'][0]['speed'] = $v['Tspeed'];

			$this->json['tarifs'][0]['tarifs'][$v['id']]['ID'] = $v['id'];
			$this->json['tarifs'][0]['tarifs'][$v['id']]['title'] = $v['title'];
			$this->json['tarifs'][0]['tarifs'][$v['id']]['price'] = $v['price'];
			$this->json['tarifs'][0]['tarifs'][$v['id']]['pay_period'] = $v['payperiod'];
			$this->json['tarifs'][0]['tarifs'][$v['id']]['new_payday'] = strtotime('today midnight + '.$v['payperiod'].' month').''.date('O');// текущая дата полночь + pay_period + смещение
			$this->json['tarifs'][0]['tarifs'][$v['id']]['speed'] = $v['speed'];
		}
		}
	}
	



}
