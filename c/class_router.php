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
		
		//определяем метод
		foreach($actions as $k=>$v){
			if($k == $URI[count($URI)-1]){
				$this->method = $v;
			}
		}
		
		//Разбираем урл
		$URI = explode('/',$_SERVER['REQUEST_URI']);	
		foreach($URI as $k=>$v){			
			if(in_array($v,$acc_m)){				
				$this->data[$v]=(int)$URI[$k+1];	
					if($this->data[$v]==0)$this->method = 'error';
			}			
		}
		
		
	
   	}

}
