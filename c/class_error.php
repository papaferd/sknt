<?php
defined('BASES') OR exit('No direct script access allowed');

/**
 * jsonError - создает пустой массив для json
 */

class jsonError{
	
var $json;
var $query;
	
	function __construct($e) {	
		
		$this->json = array();
	
   	}

}
