<?php
defined('BASES') OR exit('No direct script access allowed');
/*
Логгирует Exception
*/

class loggingException extends Exception{
	
var $error;
	public function __construct($m,$e='') {	
		$this->error = $m.' >> '.$e;
		Exception::__construct($this->error); 
		$this->logdir($this->error);
		
		
   	}
	
	public function logdir($message){
		$message = date(r).' || '.$message.'
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
