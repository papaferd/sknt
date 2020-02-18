<?php
defined('BASES') OR exit('No direct script access allowed');

/**
 * Router - Разбирает урл и опредлеляет метод для выполнения
 */

class router{
	
var $method;
var $data;

	
	function __construct() {	
		
		$this->data = array();
		//$getline - переменные в адресной строке
		$getline= array(
		'users',
		'services'
		);	
		//$actions - переменные в адресной строке, модификаторы действия
		$actions = array(
		'tarif'=>'PutTarif',
		'tarifs'=>'GetTarifs'
		);
		$URI = explode('/',$_SERVER['REQUEST_URI']);
		
		
		//Разбираем урл
		foreach($URI as $k=>$v){			
			if(in_array($v,$getline)){			
				$this->data[$v]=(int)$URI[$k+1];	
					if($this->data[$v]==0)$this->method = 'jsonError';
			}else{$this->method = 'jsonError';}
		}
		
		
		//определяем метод
		foreach($actions as $k=>$v){
			if($k == $URI[count($URI)-1]){
				$this->method = $v;
			}
		}
		
		
	
   	}

}
