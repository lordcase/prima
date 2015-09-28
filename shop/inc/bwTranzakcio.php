<?php

if(!defined("BW_APPLICATION"))
{
  die("Direct access to this internal component is forbidden.");
}

class bwTranzakcio extends bwDataset {

  function bwTranzakcio()
  {
    $this->SetTable('cba_tranzakcio');
    $this->SetFields('id, php_self, referer, ip, user_id, product_id, product_name, start_date, price, processed, created');
    $this->SetPrimaryKey('id');
  }
    
  function Start($product_id, $start_date, $price, $product_name = '')
  {
    global $session;
	global $database;
  
    $values = array();

    $values['product_id'] = $product_id;
    $values['start_date'] = $start_date;
    $values['price'] = $price;
    $values['product_name'] = $product_name;
    
    $values['php_self'] = $_SERVER['PHP_SELF'];
    $values['referer'] = $_SERVER['HTTP_REFERER'];
    
    if (getenv('HTTP_CLIENT_IP'))
    {
      $values['ip'] = getenv('HTTP_CLIENT_IP');
    }
    elseif (getenv('HTTP_X_FORWARDED_FOR'))
    {
      $values['ip'] = getenv('HTTP_X_FORWARDED_FOR');
    }
    elseif (getenv('HTTP_X_FORWARDED'))
    {
      $values['ip'] = getenv('HTTP_X_FORWARDED');
    }
    elseif (getenv('HTTP_FORWARDED_FOR'))
    {
      $values['ip'] = getenv('HTTP_FORWARDED_FOR');
    }
    elseif (getenv('HTTP_FORWARDED'))
    {
      $values['ip'] = getenv('HTTP_FORWARDED');
    }
    else {
      $values['ip'] = $_SERVER['REMOTE_ADDR'];
    }    

    $values['user_id'] = ($session->logged_in) ? $session->user['id'] : 0;

    $values['created'] = date('Y-m-d H:i:s');
	
    $this->Insert($values);
	
	return $database->GetInsertId();
        
  }  
  
  function Folytat($id)
  {
  	global $database;
	
	$sql = "SELECT * FROM cba_tranzakcio WHERE id='" . mysql_real_escape_string($id) . "' AND processed < 2 LIMIT 1";

    if($database->Query($sql) && ($row = $database->FetchRow()))
    {
		if($row['processed'] == 1)
		{
			$sql = 'UPDATE cba_tranzakcio'
			   . " SET processed = '1'"
			   . ' WHERE id = \'' . mysql_real_escape_string($id) . '\''
			   . ' LIMIT 1';
			   
			$database->Query($sql);
		}
	
		return $row;
	}
	else
	{
		return false;
	}
  }
  
  function Befejez($id)
  {
  	global $database;
	
	$sql = 'UPDATE cba_tranzakcio'
	   . " SET processed = '2'"
	   . ' WHERE id = \'' . mysql_real_escape_string($id) . '\''
	   . ' LIMIT 1';
	   
	if($database->Query($sql))
	{
		return true;
	}
	else
	{
		return false;
	}
  }
  
  function GetTranzakciokForVevo($vevoId)
  {
  	global $database;
	
	$sql = "SELECT * FROM cba_tranzakcio WHERE user_id='" . mysql_real_escape_string($vevoId) . "' AND processed > 0 ";

    if ($database->Query($sql))
	{
		$tranzakciok = array();
		
		while ($row = $database->FetchRow())
		{
			$tranzakciok[] = $row;
		}
		
		return $tranzakciok;
	}
	else
	{
		return false;
	}

  }

  function GetVevoLista()
  {
  	global $database;
	
	$sql = "SELECT DISTINCT v.* FROM cba_user v, cba_tranzakcio t WHERE v.id = t.user_id AND t.processed > 0 ORDER BY v.nick ASC ";
	
    if ($database->Query($sql))
	{
		$records = array();
		
		while ($row = $database->FetchRow())
		{
			$records[] = $row;
		}
		
		return $records;
	}
	else
	{
		return false;
	}

  }

  function GetTermekLista()
  {
  	global $database;
	
	$sql = "SELECT DISTINCT product_id, product_name FROM cba_tranzakcio WHERE processed > 0 ORDER BY product_name ASC ";

    if ($database->Query($sql))
	{
		$records = array();
		
		while ($row = $database->FetchRow())
		{
			$records[] = $row;
		}
		
		return $records;
	}
	else
	{
		return false;
	}

  }

  function GetTranzakciokForTermek($termekId)
  {
  	global $database;
	
	$sql = "SELECT t.*, v.nick AS user_name FROM cba_tranzakcio t, cba_user v WHERE t.product_id = '" . $termekId . "' AND t.user_id = v.id AND t.processed > 0 ORDER BY t.created DESC ";

    if ($database->Query($sql))
	{
		$tranzakciok = array();
		
		while ($row = $database->FetchRow())
		{
			$tranzakciok[] = $row;
		}
		
		return $tranzakciok;
	}
	else
	{
		return false;
	}

  }

  function GetHaviLista($ev, $ho)
  {
  	global $database;
	
	$startDate 	= $ev . '-' . $ho . '-01';
	$endDate 	= $ev . '-' . $ho . '-31';
	
	$sql = "SELECT t.*, v.nick AS user_name FROM cba_tranzakcio t, cba_user v WHERE v.id = t.user_id AND t.processed > 0 AND t.created >= '$startDate' AND t.created <= '$endDate' ORDER BY t.created DESC ";

    if ($database->Query($sql))
	{
		$records = array();
		
		while ($row = $database->FetchRow())
		{
			$records[] = $row;
		}
		
		return $records;
	}
	else
	{
		return false;
	}

  }



}

$tranzakcio = new bwTranzakcio();

?>
