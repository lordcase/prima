<?php

define('BW_USER_ITEMS_PER_PAGE', 30);

class bwUser {
  
  var $feedback;
  var $saved;
  
  var $item;
  
  var $currentPage;
  var $lastPage;
  var $sortField;
  var $sortDir;
  
  function bwUser()
  {
    global $GET;
  
    $this->feedback = '';
    $this->saved = false;
  
    $this->currentPage = intval($GET->Item('oldal', 1));
    $this->lastPage = $this->GetLastPage();
    if($this->currentPage > $this->lastPage) $this->currentPage = $this->lastPage;
    if($this->currentPage < 1) $this->currentPage = 1;
    
    $this->SetSorting();
  
    if(isset($_POST['formId']))
    {
      switch($_POST['formId'])
      {
        case 'USER:REGISTER':
          $this->NewUser();
        break;
        case 'USER:UPDATE':
          $this->UpdateUser();
        break;
        case 'USER:DELETE':
          $this->DeleteUser();
        break;
      }
      
    }
    
    $this->GetUsers();

  }
  
  function GetLastPage()
  {
    global $database;
    
    $sql = "SELECT COUNT(*)"
         . " FROM " . TBL_USER
         . " WHERE active = '1'";
         
    if($database->Query($sql) && ($row = $database->FetchRow()))
    {
      return ceil($row[0] / BW_USER_ITEMS_PER_PAGE);
    }
    else return 0;
  }
  
  function GetUsers()
  {
    global $database;
    
    $this->item = array();
    
    $sql = "SELECT *"
         . " FROM " . TBL_USER
         . " WHERE active = '1'"
         . " ORDER BY " . $this->sortField . ' ' . $this->sortDir
         . " LIMIT " . (($this->currentPage - 1) * BW_USER_ITEMS_PER_PAGE) . ", " . BW_USER_ITEMS_PER_PAGE;
    
    if($database->Query($sql))
    {
      $levelText = array(0 => 'tag', 1 => 'superuser', 2 => 'editor', 3 => 'moderator', 5 => 'supermoderator', 9 => 'admin');
      while($row = $database->FetchRow())
      {
        $row['level_text'] = $levelText[$row['level']];
        $this->item[] = $row;
      }
    }
  }
  
  function NewUser()
  {
    global $database;
  
    $ok = true;
    $newEmail = trim(htmlspecialchars($_POST['user_email']));
    $newName = trim(htmlspecialchars($_POST['user_name']));
    $newPassword1 = trim($_POST['user_password1']);
    $newPassword2 = trim($_POST['user_password2']);
    $newSecretCode = trim(htmlspecialchars($_POST['user_secretcode']));
    $newSubscription = isset($_POST['user_subscription']) ? 1 : 0;
    
    if(preg_match( "/^[\d\w\/+!=#|$?%{^&}*`'~-][\d\w\/\.+!=#|$?%{^&}*`'~-]*@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i", $newEmail) == 0)
    {
      $ok = false;
      $this->feedback .= 'Kérlek, adj meg valódi emailcímet!<br />';
    }
    
    if($newName == '')
    {
      $ok = false;
      $this->feedback .= 'A felhasználónév nem lehet üres!<br />';
    }
    
    if((strlen($newPassword1) < 5) || (strlen($newPassword1) > 20))
    {
      $ok = false;
      $this->feedback .= 'A jelszó legalább 5, legfeljebb 20 karakter hosszú kell hogy legyen!<br />';
    }
    
    if($newPassword1 != $newPassword2)
    {
      $ok = false;
      $this->feedback .= 'A jelszó és a jelszó megerõsítés mezõk tartalma nem egyezik!<br />';
    }
    
    if($ok)
    {
      if($database->UserNameExists($newName))
      {
        $this->feedback .= 'Regisztráció sikertelen. Felhasználónév már foglalt!<br />';
      }
      elseif($database->UserEmailExists($newEmail))
      {
        $this->feedback .= 'Regisztráció sikertelen. A megadott emailcím már regisztrálva van!<br />';
      }
      else
      {
        $sql = "INSERT INTO " . TBL_USER
             . " ( `id` , `nick` , `email` ,  `password` , `secret_code` , `active` , `subscription` , `level` , `created` , `last_login` )"
             . " VALUES ('', '" . $newName . "', '" . $newEmail . "', '" . md5($newPassword1) . "', '" . $newSecretCode . "', '1', '" . $newSubscription . "', '0', NOW(), '' )";

        if($database->Query($sql))
        {
          $this->feedback .= "Reigsztráció sikeres.<br />";
          $this->saved = true;
        }
        else
        {
          $this->feedback .= _DATABASE_ERROR . '<br />';
        }

      }
    }
  }
  
  function UpdateUser()
  {
    global $database;
    global $session;
  
    $ok = true;
    
    $newId = intval($_POST['user_id']);

    if($session->logged_in && ($newId == $session->user['id'] ))
    {
      $newEmail = trim(htmlspecialchars($_POST['user_email']));
      $newName = trim(htmlspecialchars($_POST['user_name']));
      $newPassword1 = trim($_POST['user_password1']);
      $newPassword2 = trim($_POST['user_password2']);
	    $newSecretCode = trim(htmlspecialchars($_POST['user_secretcode']));
      $newSubscription = isset($_POST['user_subscription']) ? 1 : 0;
      
      if(preg_match( "/^[\d\w\/+!=#|$?%{^&}*`'~-][\d\w\/\.+!=#|$?%{^&}*`'~-]*@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i", $newEmail) == 0)
      {
        $ok = false;
        $this->feedback .= 'Kérlek, adj meg valódi emailcímet!<br />';
      }
      
      if($newName == '')
      {
        $ok = false;
        $this->feedback .= 'A felhasználónév nem lehet üres!<br />';
      }
      
      if(($newPassword != '') && ((strlen($newPassword1) < 5) || (strlen($newPassword1) > 20)))
      {
        $ok = false;
        $this->feedback .= 'A jelszó legalább 5, legfeljebb 20 karakter hosszú kell hogy legyen!<br />';
      }
      
      if($newPassword1 != $newPassword2)
      {
        $ok = false;
        $this->feedback .= 'A jelszó és a jelszó megerõsítés mezõk tartalma nem egyezik!<br />';
      }
      
      if($ok)
      {
        if(($newName != $session->user['nick']) && $database->UserNameExists($newName))
        {
          $this->feedback .= 'Hiba. Az új felhasználónév már foglalt!<br />';
        }
        elseif(($newEmail != $session->user['email']) && $database->UserEmailExists($newEmail))
        {
          $this->feedback .= 'Hiba. A megadott emailcímet már valaki más használja!<br />';
        }
        else
        {
        
          $sqlPassword = ($newPassword1 == '') ? "" : " password='" . md5($newPassword1) .  "',";

          $sql = "UPDATE " . TBL_USER
               . " SET nick = '" . $newName . "', email = '" . $newEmail . "'," . $sqlPassword . " secret_code = '" . $newSecretCode . "', subscription = '" . $newSubscription . "'"
               . " WHERE id = '" . $newId . "'"
               . " LIMIT 1";

          if($database->Query($sql))
          {
            $this->feedback .= "Módosítások sikeresen végrehajtva.<br />";
            $this->saved = true;
          }
          else
          {
            $this->feedback .= _DATABASE_ERROR . '<br />';
          }
  
        }
      }
    }
    else
    {
      $this->feedback .= "Hozzáférés megtagadva.<br />";
    }
      
  }
  
  function DeleteUser()
  {
  
  }

  function SetSorting()
  {
    global $GET;
    
    $sortFields = array('nev' => 'nick',
                        'email' => 'email',
                        'hirlevel' => 'subscription',
                        'szint' => 'level',
                        'regisztracio' => 'created',
                        'login' => 'last_login');
    
    $this->sortField = isset($sortFields[$GET->Item('rendezes')]) ? $sortFields[$GET->Item('rendezes')] : 'nick';
    $this->sortDir = $GET->Item('vissza') ? 'DESC' : 'ASC'; 
  }

  function GetFormURL($page = false, $field = false)
  {
    $sortLabels = array('nick' => 'nev',
                        'email' => 'email',
                        'subscription' => 'hirlevel',
                        'level' => 'szint',
                        'created' => 'regisztracio',
                        'last_login' => 'login');
    


    if(!$page) $page = $this->currentPage;
    
    $url = $_SERVER['PHP_SELF'] . '?oldal=' . $page;
    if($field === false)
    {
      $url .= '&rendezes=' . $sortLabels[$this->sortField];
      if($this->sortDir == 'DESC') $url .= '&vissza=1';
    }
    else
    {
      $url .= '&rendezes=' . $sortLabels[$field];
      if(($field == $this->sortField) && ($this->sortDir == 'ASC')) $url .= '&vissza=1';
    }
    
    return $url;
  }

}

$user = new bwUser;

?>
