<?php

if(!defined("BW_APPLICATION"))
{
  die("Direct access to this internal component is forbidden.");
}

define('BW_LOG_LOW', 0);
define('BW_LOG_MEDIUM', 1);
define('BW_LOG_HIGH', 2);
define('BW_LOG_CRITICAL', 3);
define('BW_LOG_UNDEFINED', BW_LOG_LOW);


class bwLog extends bwDataset {

  function bwLog()
  {
    $this->SetTable(TBL_LOG);
    $this->SetFields('id, level, module, php_self, referer, ip, user_id, event_type, product_id, return_code_bank, return_code_shop, amount_paid, created, body');
    $this->SetPrimaryKey('id');
  }
    
  function Log($module, $message, $level, $vasarlas = NULL)
  {
    global $session;
  
    $values = array();

    $values['module'] = $module;
    $values['body'] = $message;
    
    switch($level)
    {
      case BW_LOG_LOW:
      case BW_LOG_MEDIUM:
      case BW_LOG_HIGH:
      case BW_LOG_CRITICAL:
        $values['level'] = $level;
      break;
      default:
        $values['level'] = BW_LOG_UNDEFINED;
    }
  
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
	
	if ($vasarlas == NULL)
	{
		$values['event_type'] = 0;
		$values['product_id'] = 0;
		$values['return_code_bank'] = 0;
		$values['return_code_shop'] = 0;
		$values['amount_paid'] = 0;
	}
	else
	{
		$values['event_type'] = $vasarlas['event_type'];
		$values['product_id'] = $vasarlas['product_id'];
		$values['return_code_bank'] = $vasarlas['return_code_bank'];
		$values['return_code_shop'] = $vasarlas['return_code_shop'];
		$values['amount_paid'] = $vasarlas['amount_paid'];
	}
    
    $this->Insert($values);
        
  }
  
  function LogVasarlasStart($productId, $amount_paid)
  {
  	$message = 'Online vásárlás tranzakció indítása';
  
	$values['event_type'] = 1;
	$values['product_id'] = $productId;
	$values['return_code_bank'] = 0;
	$values['return_code_shop'] = 0;
	$values['amount_paid'] = $amountId;
	
	$this->Log('online_vasrlas', $message, BW_LOG_LOW, $values);
  }
  
  function LogVasarlasBankiValasz($productId, $amount_paid, $banki_valasz)
  {
  	$message = 'Online vásárlás tranzakció: válasz a banktól';
  
	$values['event_type'] = 2;
	$values['product_id'] = $productId;
	$values['return_code_bank'] = $banki_valasz;
	$values['return_code_shop'] = 0;
	$values['amount_paid'] = $amount_paid;
	
	$this->Log('online_vasrlas', $message, BW_LOG_LOW, $values);
  }

  function LogVasarlasShopValasz($productId, $amount_paid, $shop_valasz)
  {
  	$message = 'Online vásárlás tranzakció: válasz a shoptól';
  
	$values['event_type'] = 3;
	$values['product_id'] = $productId;
	$values['return_code_bank'] = 0;
	$values['return_code_shop'] = $shop_valasz;
	$values['amount_paid'] = $amount_paid;
	
	$this->Log('online_vasrlas', $message, BW_LOG_LOW, $values);
  }

	function SelectAllFoglalas()
	{
		//$where_sql = "module='bwRemoteServices'";
		//return $this->SelectAllWhere($where_sql);
		
		global $database;
		
		$sql = "SELECT cba_log.*, cba_user.nick AS user_nick, cba_user.email AS user_email FROM cba_log, cba_user WHERE cba_log.user_id = cba_user.id AND cba_log.module='bwRemoteServices' ORDER BY cba_log.created DESC";

		if($database->Query($sql))
		{
		  $this->item = array();
		  
		  while($row = $database->FetchRow()) 
		  {
			$this->item[] = $row;
		  }
		  
		  //$this->error = false;
		}
		else
		{
		  $this->SetFeedback(DB_ERROR, BW_ERROR);
		  //$this->error = true;
		}
	}

	function SelectFoglalasByMonth($ym)
	{
		// $ym "ÉÉÉÉ-HH" formátumú kell hogy legyen!!!!
		
		global $database;


		$where = "";
			
		$sql = "SELECT cba_log.*, cba_user.nick AS user_nick, cba_user.email AS user_email FROM cba_log, cba_user WHERE cba_log.user_id = cba_user.id AND cba_log.module='bwRemoteServices' AND cba_log.created BETWEEN '" . $ym . "-01' AND '" . $ym . "-31' ORDER BY cba_log.created DESC";
	
		if($database->Query($sql))
		{
		  $this->item = array();
		  
		  while($row = $database->FetchRow()) 
		  {
			$this->item[] = $row;
		  }
		  
		  //$this->error = false;
		}
		else
		{
		  $this->SetFeedback(DB_ERROR, BW_ERROR);
		  //$this->error = true;
		}
	}

	function SelectFoglalasByUser($id)
	{
		global $database;

		$where = "";
			
		//$sql = "SELECT cba_log.*, cba_user.nick AS user_nick, cba_user.email AS user_email FROM cba_log, cba_user WHERE cba_log.user_id = cba_user.id AND cba_log.module='bwRemoteServices' AND cba_user.id = '" . $id . "' ORDER BY cba_log.created DESC";
		$sql = "SELECT cba_log.*, cba_user.nick AS user_nick, cba_user.email AS user_email FROM cba_log, cba_user WHERE cba_log.user_id = cba_user.id AND cba_user.id = '" . $id . "' ORDER BY cba_log.created DESC";
	
		if($database->Query($sql))
		{
		  $this->item = array();
		  
		  while($row = $database->FetchRow()) 
		  {
			$this->item[] = $row;
		  }
		  
		  //$this->error = false;
		}
		else
		{
		  $this->SetFeedback(DB_ERROR, BW_ERROR);
		  //$this->error = true;
		}
	}

}

$log = new bwLog();

?>
