<?php
defined('BASES') OR exit('No direct script access allowed');

/**
 * DataMYSQL - Класс работы с базой данных, 
 * функции: 
 *    getquery - Выполнить запрос
 *    getdata - выполнить запрос и вернуть данные в массиве
 */

class DataMYSQL{
	
	var $dbh;
	public function __construct() {	
		$this->dbh=mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die ('Не могу установить соединение с базой MYSQL: ' . mysqli_error($this->dbh));	 
		mysqli_set_charset($this->dbh,'utf8');
		if(mysqli_error($this->dbh))throw new loggingException('Can not create DB connection',mysqli_error($this->dbh));
   	}
	
	public function __destruct() {       
		mysqli_close($this->dbh);   
	}
	
	private function pingmysql($query){
		if (!mysqli_ping($this->dbh)){
				throw new loggingException('MYSQL Error, Bad PING DB',$query);
		}
	}
	
	public function getquery($query='')
	{

		$this->pingmysql($query);

			mysqli_query($this->dbh,$query);
			
				if(mysqli_error($this->dbh))
				{
					throw new loggingException('MYSQL Error, Bad query->'.mysqli_error($this->dbh),$query);
				}

	}
	
	
	public function getdata($query='')
	{

		if($query!='')
		{
						
				$this->pingmysql($query);
				
				
			$data = array();
			$query_list = mysqli_query($this->dbh,$query);
			
				if(!mysqli_error($this->dbh))
				{
					
					if(stristr($query,'SELECT')){
						
						while ($row = mysqli_fetch_array($query_list, MYSQLI_ASSOC)) 
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
