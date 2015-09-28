<?php

if(!defined("BW_APPLICATION"))
{
  die("Direct access to this internal component is forbidden.");
}

class bwArticle {

  function bwArticle()
  {
    //dunny
  }
  
  function Get($title)
  {
    global $database;

    $sql = "SELECT * "
         . " FROM " . TBL_ARTICLE
         . " WHERE title = '" . $title . "' ";

    if($database->Query($sql) && ($row = $database->FetchRow()))
    {
      return $row;
    }
    else
    {
      return false;
    }

  }
  
  function GetBody($title)
  {
  	if ($row = $this->Get($title))
	{
		return $row['body'];
	}
	else
	{
		return '';
	}
  }
  
    
  function Exists($title)
  {
    global $database;
  
    $sql = "SELECT * "
         . " FROM " . TBL_ARTICLE
         . " WHERE title = '" . $title . "' ";

    return ($database->Query($sql) && (mysql_num_rows($database->GetResource())>0));

  }

  function IsVisible($title)
  {
    global $database;
  
    $sql = "SELECT * "
         . " FROM " . TBL_ARTICLE
         . " WHERE title = '" . $title . "' ";

    if ($database->Query($sql) && ($row = mysql_fetch_assoc($database->GetResource())))
	{
		return ($row['visible'] == '1');
	}
	else
	{
		return false;
	}
  }

  function Show($title)
  {
  	return $this->ShowOrHide($title, 1);
  }
  
  function Hide($title)
  {
  	return $this->ShowOrHide($title, 0);
  }
  
  function ShowOrHide($title, $visible)
  {
    global $database;
  
    if($this->Exists($title))
    {
      $sql = "UPDATE " . TBL_ARTICLE
           . " SET visible = '" . $visible . "'"
           . " WHERE title = '" . $title . "'"
           . " LIMIT 1";
		   
	  return $database->Query($sql); 
	}
	else
	{
		return false;
	}
  }  
  
  
  function Set($title, $body)
  {
    global $database;
	global $session;
	
	$newModerator_id = $session->user[id];
  
    if($this->Exists($title))
    {
      $sql = "UPDATE " . TBL_ARTICLE
           . " SET body = '" . $body . "', modifier_id = '" . $newModerator_id . "', modified = NOW()"
           . " WHERE title = '" . $title . "'"
           . " LIMIT 1";
    }
    else
    {
      $sql = "INSERT INTO " . TBL_ARTICLE
           . " ( `id` , `title` , `visible` , `body` , `author_id` , `modifier_id` , `created`, `modified`  )"
           . " VALUES ('" . $id . "', '" . $title . "', '0', '" . $body . "', '" . $newModerator_id . "', '" . $newModerator_id . "', NOW(), NOW() )";
    }
	
    return $database->Query($sql); 
  }  

  function Delete($id)
  {
    global $database;
    
    $sql = "DELETE FROM " . TBL_ARTICLE
         . " WHERE id = '" . $id . "'"
         . " LIMIT 1";
  
    $database->Query($sql); 
  }
  
}

$article = new bwArticle();

?>
