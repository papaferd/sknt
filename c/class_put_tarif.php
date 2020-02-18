<?php
defined('BASES') OR exit('No direct script access allowed');

/**
 * PutTarif - устанавливает выбранный тариф пользователю в базе
 */

class PutTarif extends GetTarifs{

	
	function __construct(array $data) {	
		
		GetTarifs::__construct($data);			
		$put = json_decode(file_get_contents('php://input'),true);
		
		//Проверяем массив и за одно переменную для изменения
		if(is_array($put) && !isset($put['tarif_id'])){
			
				$put['tarif_id'] = htmlspecialchars($put['tarif_id']);//Хучь так
			
			if(isset($this->jjson['tarifs'][0]['tarifs'][$put['tarif_id']])){	
				$newpayday = date("Y-m-d",substr($this->jjson['tarifs'][0]['tarifs'][$put['tarif_id']]['new_payday'], 0 , -4));
				$query = 'UPDATE `services` SET `tarif_id`='.$put['tarif_id'].',`payday`="'.$newpayday.'" WHERE `user_id`='.$data['users'];
				$this->getquery($query);
				$this->jjson = array('result'=>'ok');
				
			}else{
				$this->jjson = array();
			}	
			
		}else{
			$this->jjson = array();
		}	
   	}
}
