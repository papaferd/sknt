<?php
defined('BASES') OR exit('No direct script access allowed');

class HTMLcontroller{
	
	public function __construct($jJson) {	
		if(!is_array($jJson->jjson))$jJson->jjson=array();
		$this->get_header_ok();			
		count($jJson->jjson)<1?$this->json_err():$this->get_html($this->get_json($jJson->jjson));		
   	}
	
	private function get_header_contetnt_type(){
		header('Content-Type: text/html; charset=utf8');	
	}
	
	private function get_header_ok(){
		$this->get_header_contetnt_type();
		header('HTTP/1.0 200 OK');	
	}
	
	private function get_header_404(){
		$this->get_header_contetnt_type();	
		header('HTTP/1.0 404 Not Found');
		header('Status: 404 Not Found');
	}
	
	
	private function get_html($t){	
		print($t);
		die;	
	}
	
	private function get_json($array){
		//Для пхп <5.4
		$j = defined('JSON_UNESCAPED_UNICODE')?json_encode($array, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ):str_replace('\/','/',json_encode($array));
		return($j);
	}
	
	
	public function er404($er){
		$this->get_header_404();
		$t ='HTTP/1.0 404 Not Found<br>'.$er;
		loggingException::logdir($er.'>>'.$_SERVER['REQUEST_URI']);
		$this->get_html($t);
	}

	public function json_err(){
		$this->get_header_404();
		$arr = array('result'=>'error');
		loggingException::logdir('JSON_error>>'.$_SERVER['REQUEST_URI']);
		$this->get_html($this->get_json($arr));

	}
	
	
}
