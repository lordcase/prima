<?php

if(!defined("BW_APPLICATION"))
{
  die("Direct access to this internal component is forbidden.");
}

class bwSession {

  var $user = array();
  var $logged_in;
  
  const UNKNOWN = -1;
  const REGISTERED = 0;
  const SUPER_USER = 1;
  const EDITOR = 2;
  const MODERATOR = 3;
  const SUPER_MODERATOR = 5;
  const ADMIN = 9;

  function bwSession()
  {
    global $database;
    global $log;
    
    session_start();

	setlocale(LC_TIME, 'hu_HU');
	
    if(isset($_SESSION[BW_SESSION_USERID]))
    {
      if($database->UserIdExists($_SESSION[BW_SESSION_USERID]))
      {
        $this->user = $database->GetRow();
        $this->logged_in = true; 
      }
    }
    else
    {
      $this->logged_in = false;
    }

    if(isset($_POST['formId']))
    {
      switch($_POST['formId'])
      {
        case 'USER:LOGIN':
          if(!$this->logged_in && $database->Login($_POST['email'], $_POST['password']))
          {
            $this->SetUser($database->GetField('id'));
            if($this->GetUserLevel() >= bwSession::SUPER_USER)
            {
              $log->Log('bwSession', 'Level ' . $this->GetUserLevel() . ' user ' . $this->user['nick'] . ' (id # ' . $this->user['id'] . ') logs in.'  , BW_LOG_LOW);
            }
          }
        break;
        case 'USER:LOGOUT':
          if($this->logged_in)
          {
            $this->ClearUser();
          }
        break;
      }
    }

    /*$this->logged_in = false;
    $this->ClearUser();*/

  }
  
  function SetUser($id)
  {
    global $database;
  
    if($database->UserIdExists($id))
    {
      $_SESSION[BW_SESSION_USERID] = $id;
      $this->user = $database->GetRow();  
      $this->logged_in = true;
      return true;
    }
    
    return false;
  }

  function ClearUser()
  {
    unset($this->user);
    $this->logged_in = false;
    
    session_unset();
  }

  function GetUserLevel()
  {
    return $this->logged_in ? $this->user['level'] : bwSession::UNKNOWN;
  }

}

global $session;

$session = new bwSession();

?>
