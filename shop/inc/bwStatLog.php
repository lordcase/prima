<?php

define('STAT_DEFAULT_MONTH', '2007-05');
$ym = "";
$where = "";


class bwStatLog {

  function bwStatLog()
  {
    if(!defined('BW_NOSTAT'))
    {
      $this->RegisterVisit();
    }
  }

  function RegisterVisit($pageName = '')
  {
    global $database;
  
    if($pageName=='') $pageName = $_SERVER['REQUEST_URI'];
  
    $sql = "SELECT * FROM " . TBL_VISIT 
         . " WHERE page = '$pageName' AND  remote_addr = '" . $_SERVER["REMOTE_ADDR"] . "' AND date = '" . date("Y-m-d") . "' AND hour = '" . date("H") . "' "
         . " LIMIT 1";
     
    if($database->Query($sql) && !(mysql_num_rows($database->GetResource()) >= 1))
    {
      $referer = (substr($_SERVER["HTTP_REFERER"], 7, strlen($_SERVER["HTTP_HOST"])) != $_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_REFERER"] : "local";
      
      $sql = "INSERT INTO " . TBL_VISIT 
           . " ( `id` , `page` , `date` , `hour` , `time` , `remote_addr` , `http_referer` )"
           . " VALUES ('', '$pageName', '" . date("Y-m-d") . "', '" . date("H") . "', '" . date("H:i:s") . "', '" . $_SERVER["REMOTE_ADDR"] . "', '" . $referer . "');";
      
      $database->Query($sql);
    }
  }
}

$statLog = new bwStatLog();

?>
