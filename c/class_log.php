<?php
defined('BASES') OR exit('No direct script access allowed');
/*
Логгирует Exception
*/

class loggingException extends Exception{
	
var  $log;
var  $dirl;

	public function __construct($m,$e='') {	
		$message = date(r).' || '.$m.' >> '.$e.'
';
		Exception::__construct($message);
		
		$this->dirl = $_SERVER['DOCUMENT_ROOT'].'/log/';	
				
		if (!is_dir($this->dirl))
		{
		   if(!mkdir($this->dirl, 0755)){
			   echo "Not a create log dir";die;		   
		   }
			
		}
		
		$this->log = $this->dirl.'log.l';
		if(!file_put_contents($this->log, $message,  FILE_APPEND)){echo 'Not a save log file';die;}	
		
   	}

}
