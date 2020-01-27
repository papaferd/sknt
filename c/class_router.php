<?php
defined('BASES') OR exit('No direct script access allowed');
/*
Простенький роутер
*/

class router{
	
var $method;
var $data;

	
	function __construct() {	
		
		$this->data = array();
		//$acc_m - переменные, и действия
		$acc_m = array(
		'users',
		'services'
		);	
		$actions = array(
		'tarif'=>'put_tarif',
		'tarifs'=>'get_tarifs'
		);
		
		
		//Разбираем урл
		$URI = explode('/',$_SERVER['REQUEST_URI']);	
		foreach($URI as $k=>$v){			
			if(in_array($v,$acc_m)){				
				$this->data[$v]=$URI[$k+1];				
			}			
		}
		//определяем метод
		foreach($actions as $k=>$v){
			if($k == $URI[count($URI)-1]){
				$this->method = $v;
			}
		}
		
		
		if($this->method=='' or (int)$this->data['users']==0 or (int)$this->data['services']==0)$this->method = 'error';
	
   	}

}
