<?php
defined('BASES') OR exit('No direct script access allowed');

/**
 * loggingException - Класс Логгирования ошибок в свой лог 
 * функции: 
 *    __construct - выполнить логгрование, вывести увдеомление
 *    logdir - public, static, выполнить запрос и вернуть данные в массиве
 */

if(!class_exists('Throwable')){
	
	abstract class logMethod extends Exception{

		public function __construct($errors='') {	
			Exception::__construct($$errors); 

		}

	}

	
}else{
	
	abstract class logMethod extends Throwable{


		public function __construct($errors='') {	
			Throwable::__construct($errors);
		}

	}
}

class loggingException extends logMethod{
	
/**
 * Error Message
 *@var - string
 */	
	
var $Log_Error;	
	
		public function __construct($messages,$error='') {	
			$this->Log_Error = $messages.' >> '.$error;
			logMethod::__construct($this->Log_Error); 
			$this->logdir($this->Log_Error);


		}
	
		public static function logdir($message){
		$message = date("r").' || '.$message.'
';
		$dirl = $_SERVER['DOCUMENT_ROOT'].'/log/';	
				
		if (!is_dir($dirl))
		{
		   if(!mkdir($dirl, 0755)){
			   echo "Not a create log dir";die;		   
		   }
			
		}
		
		$log = $dirl.'log.l';
		if(!file_put_contents($log, $message,  FILE_APPEND)){echo 'Not a save log file';die;}	
		
	}
	
}

