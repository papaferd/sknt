<?php
defined('BASES') OR exit('No direct script access allowed');
/*
Логгирует Exception
*/

if(!class_exists('Throwable')){
	
	class loggingDir extends Exception{

		public function __construct($errors='') {	
			Exception::__construct($$errors); 

		}

	}

	
}else{
	
	class loggingDir extends Throwable{


		public function __construct($errors='') {	
			Throwable::__construct($errors);
		}

	}
}

class loggingException extends loggingDir{
	
var $Log_Error;	
	
		public function __construct($messages,$error='') {	
			$this->Log_Error = $messages.' >> '.$error;
			loggingDir::__construct($this->Log_Error); 
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

