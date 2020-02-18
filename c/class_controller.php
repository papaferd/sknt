<?php
defined('BASES') OR exit('No direct script access allowed');

/**
 * HTMLcontroller - Контролер вывода HTML документа в представлении JSON
 * NOTE: Для версий PHP 5 и выше
 */

class HTMLcontroller{

	/**
	* __construct - Получает на ввод массив, где ключ == параметр, значение == значение параметра, проверяет его и выдает ответ
	*return html(header,body = JSON or Error)
	*/
	
	public function __construct($jJson) {	
		if(!is_array($jJson->jjson))$jJson->jjson=array();
		$this->getHeaderOk();			
		count($jJson->jjson)<1?$this->getJSONerror():$this->getHTML($this->getJSON($jJson->jjson));		
   	}
	
	/**
	* getHeaderContetntType - устанавливает header content type Charset=UTF8
	*/
	
	private function getHeaderContetntType(){
		header('Content-Type: text/html; charset=utf8');	
	}
	
	/**
	* getHeaderOk - устанавливает header HTTP/1.0 200 OK
	*/
	
	private function getHeaderOk(){
		$this->getHeaderContetntType();
		header('HTTP/1.0 200 OK');	
	}
	
	/**
	* getHeader404 - устанавливает header HTTP/1.0 404 Not Found
	*/	
	
	private function getHeader404(){
		$this->getHeaderContetntType();	
		header('HTTP/1.0 404 Not Found');
		header('Status: 404 Not Found');
	}
	
	/**
	* getHTML - выводит полученный результат на экран, обрывает дальнейшее выполнение скрипта
	*/
	
	private function getHTML($html){	
		print($html);
		die;	
	}
	
	/**
	* getJSON - преобразует массив в JSON
	*return encoded JSON
	*/
	
	private function getJSON($array){
		//Для пхп <5.4
		$json_encoded = defined('JSON_UNESCAPED_UNICODE')?json_encode($array, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ):str_replace('\/','/',json_encode($array));
		return($json_encoded);
	}
	
	/**
	* getError404 - Публинчая функция вывода ошибки 404, public, выводит на экран страницу 404 и текст ошибки, записывает в свой лог
	*return HTML+headers
	*/
	
	public function getError404($error_text){
		$this->getHeader404();
		$html_text ='HTTP/1.0 404 Not Found<br>'.$error_text;
		LoggingException::logDIR($er.'>>'.$_SERVER['REQUEST_URI']);
		$this->getHTML($html_text);
	}

	/**
	* getJSONerror - функция вывода ошибки в ответе JSON, public
	*return HTML+headers, JSON result Error
	*/
	
	public function getJSONerror(){
		$this->getHeader404();
		$array_error = array('result'=>'error');
		LoggingException::logDIR('JSON_error>>'.$_SERVER['REQUEST_URI']);
		$this->getHTML($this->getJSON($array_error));

	}
	
	
}
