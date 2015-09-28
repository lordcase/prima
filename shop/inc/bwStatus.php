<?php

if(!defined("BW_APPLICATION"))
{
  die("Direct access to this internal component is forbidden.");
}

class bwStatus {

  function bwStatus()
  {
    //dunny
  }
  
  function Get($id)
  {
    global $database;

    $sql = "SELECT * "
         . " FROM " . TBL_STATUS
         . " WHERE id = '" . $id . "' ";

    if($database->Query($sql) && ($row = $database->FetchRow()))
    {
      return $row['value'];
    }
    else
    {
      return false;
    }

  }
    
  function Exists($id)
  {
    global $database;
  
    $sql = "SELECT * "
         . " FROM " . TBL_STATUS
         . " WHERE id = '" . $id . "' ";

    return ($database->Query($sql) && (mysql_num_rows($database->GetResource())>0));

  }
  
  
  function Set($id, $value)
  {
    global $database;
  
    if($this->Exists($id))
    {
      $sql = "UPDATE " . TBL_STATUS
           . " SET value = '" . $value . "'"
           . " WHERE id = '" . $id . "'"
           . " LIMIT 1";
    }
    else
    {
      $sql = "INSERT INTO " . TBL_STATUS
           . " ( `id` , `value` )"
           . " VALUES ('" . $id . "', '" . $value . "' )";
    }

    return $database->Query($sql); 
  }  

  function Delete($id)
  {
    global $database;
    
    $sql = "DELETE FROM " . TBL_STATUS
         . " WHERE id = '" . $id . "'"
         . " LIMIT 1";
  
    $database->Query($sql); 
  }
  
}

$status = new bwStatus();

?>
