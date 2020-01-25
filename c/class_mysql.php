<?php
defined('BASES') OR exit('No direct script access allowed');

class datamysql{
	
	var $dbh;
	function __construct() {	
		$this->dbh=mysql_connect (DB_HOST, DB_USER, DB_PASSWORD) or die ('Не могу установить соединение с базой MYSQL: ' . mysql_error());		 
		mysql_select_db (DB_NAME); 
		mysql_set_charset('utf8');
		if(mysql_error())loggingException('Can not create DB connection',mysql_error());
   	}
	
	function __destruct() {       
		mysql_close($this->dbh);   
	}
	
	function getquery($query='')
	{


			mysql_query($query);
			
				if(mysql_error())
				{
					throw new loggingException('MYSQL Error, Bad query->'.mysql_error(),$query);
				}

	}
	
	
	function getdata($query='')
	{

		if($query!='')
		{
						
				if (!mysql_ping($this->dbh)){
					loggingException('MYSQL Error, Bad PING DB',$query);
				}
				
				
			$data = array();
			$query_list = mysql_query($query);
			
				if(!mysql_error())
				{
					
					if(stristr($query,'SELECT')){
						
						while ($row = mysql_fetch_array($query_list, MYSQL_ASSOC)) 
						{
							$data[] = $row;
						}
						return $data;
						
					}else{						
						return null;
					}
					
				}else{
					
					throw new loggingException('MYSQL Error, Bad query->Error in Query',$query);
				
				}
				

		
		}else{
			
			throw new loggingException('MYSQL Error, Bad query->Error in Query',$query);
		}
		
	}
	
	
}
