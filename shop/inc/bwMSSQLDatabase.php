<?php

//require_once('inc/bwDatabase.php')

class bwMSSQLDatabase extends bwDatabase {
  
	var $connected;
	
  function bwMSSQLDatabase($server = '', $user = '', $password = '', $db = '')
  {
    $server = ($server == '') ? BW_DB_SERVER : $server;
    $user = ($user == '') ? BW_DB_USER : $user;
    $password = ($password == '') ? BW_DB_PASSWORD : $password;
    $db = ($db == '') ? BW_DB_DATABASE : $db;
  
    $this->feedback = '';
    $this->saved = false;
    $this->resoruce = false;

		setlocale(LC_TIME, '');
		
    if(($this->connection = mssql_connect($server, $user, $password)) && mssql_select_db($db, $this->connection))
    {
			$this->connected = true;
		}
		else
		{
			$this->connected = false;
		}
    
	}
  
  function Query($query)
  {
    if(BW_DEBUG_SQLDUMP) echo "<pre>SQL&gt; $query</pre>";
  
    return ($this->resource = mssql_query($query, $this->connection)) ? true : false;
  }
  
  function FetchRow()
  {
    return ($this->row = mssql_fetch_array($this->resource)) ? $this->row : false;
  }

}

?>