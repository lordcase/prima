<?php

if(!defined("BW_APPLICATION"))
{
  die("Direct access to this internal component is forbidden.");
}

class bwGuestbook {

  var $id;
  var $page;

  var $limit;

  var $item = array();
  
  var $saved;
  var $feedback;
  
  function bwGuestbook()
  {
    global $session;
  
    if(isset($_GET['bejegyzes']))
    {
      $this->id = intval($_GET['bejegyzes']);
      $this->page = 0;
      $this->limit = 'LIMIT 1';
    }
    else
    {
      $this->id = 0;
      $this->page = isset($_GET['oldal']) ? intval($_GET['oldal']) : 1;
      $this->limit = 'LIMIT ' . ($this->page - 1) * 20 . ', 20';
    }
  
    $this->saved = false;
    $this->feedback = '';
    
    if(isset($_POST['formId']))
    {
      switch($_POST['formId'])
      {
        case 'GUESTBOOK:POST':
          $this->PostNew();
        break;
        case 'GUESTBOOK:UPDATE':
          if($session->GetUserLevel() > 1) $this->UpdatePost();
        break;
        case 'GUESTBOOK:DELETE':
          if($session->GetUserLevel() > 1) $this->DeletePost();
        break;
      }
      
    }
    
    //$this->LoadPosts();
    
  }
  
  function LoadPosts($editmode = 0)
  {
    global $database;
    global $session;
    
    if(isset($_POST['formId']) && ($_POST['formId'] == 'GUESTBOOk:POST') && !$this->saved)
    {
      /*$this->item[0] = array('id' => '',
                              'nick' => htmlspecialchars($_POST['instr_nick']), 
                              'name' => htmlspecialchars($_POST['instr_name']),
                              'body' => htmlspecialchars($_POST['instr_body']),
                              'active' => htmlspecialchars($_POST['instr_active'])
                             );*/
    }
    elseif($this->id == 0)
    {
    
      if($editmode == 0)
      {
        $sql = "SELECT *"
             . " FROM " . TBL_GUESTBOOK
             . " WHERE status = '2'"
             . " ORDER BY created DESC ";
      }
      else
      {
        $sql = "SELECT *"
             . " FROM " . TBL_GUESTBOOK
             . " ORDER BY status, created DESC ";
      }

      if($database->Query($sql))
      {
        $res = $database->GetResource();
        $number = mysql_num_rows($res);
        while($row = mysql_fetch_array($res))
        {
          $row['number'] = $number;
          if($row['author_logged_in'] == 1)
          {
            if($database->UserIdExists($row['author_id']))
            {
              $userRow = $database->GetRow();
              $row['author_nick'] = $userRow['nick'];  
            }
            else
            {
              $row['author_nick'] = 'törölt regisztráció';  
            }
          }
          $this->item[] = $row;
          $number--;
        }
      }
    }
    else
    {
      //editmode checking also needs to be implemented here
      
      $sql = "SELECT *"
           . " FROM " . TBL_GUESTBOOK
           . " WHERE id = '" . $this->id . "'"
           . " LIMIT 1 ";
      
      if($database->Query($sql) && ($row = $database->FetchRow()))
      {
        if($row['author_logged_in'] == 1)
        {
          if($database->UserIdExists($row['author_id']))
          {
            $userRow = $database->GetRow();
            $row['author_nick'] = $userRow['nick'];  
          }
          else
          {
            $row['author_nick'] = 'törölt regisztráció';  
          }
        }
        $this->item[0] = $row;
      }
    
    }
  }

  
  function Exists($id)
  {
    global $database;
  
    $sql = "SELECT *"
         . " FROM " . TBL_GUESTBOOK
         . " WHERE id = '" . $id . "'"
         . " LIMIT 1";
  
    return ($database->Query($sql) && (mysql_num_rows($database->GetResource())>0));
  }
    
    
  function PostNew()
  {
    global $session;
    global $database;
  
    $this->feedback = '';
    $this->saved = false;
  
    $newTitle = trim(htmlspecialchars($_POST['gb_title']));
    if($newTitle == '') $this->feedback .= 'Kérlek, adj címet az üzenetnek!<br />';
    if($session->logged_in)
    {
      $newAuthor_logged_in = 1;
      $newAuthor_id = $session->user['id'];
      $newAuthor_nick = '';
      $newAuthor_email = '';
    }
    else
    {
      $newAuthor_logged_in = 0;
      $newAuthor_id = 0;
      $newAuthor_nick = trim(htmlspecialchars($_POST['gb_author_nick']));
      if($newAuthor_nick == '') $this->feedback .= 'Elfelejtetted megadni a neved!<br />';
      $newAuthor_email = trim(htmlspecialchars($_POST['gb_author_email']));
    }
    $newBody = trim(htmlspecialchars($_POST['gb_body']));
    if($newBody == '') $this->feedback .= 'Nem írtad le, mit szeretnél mondani!<br />';
    
    if($this->feedback == '')
    {
      $sql = "INSERT INTO " . TBL_GUESTBOOK
           . " ( `id` , `title` , `author_logged_in` , `author_id` , `author_nick` , `author_email` , `status` , `moderator_id` , `body` , `answer_body` , `created` , `answered` )"
           . " VALUES ('', '" . $newTitle . "', '" . $newAuthor_logged_in . "', '" . $newAuthor_id . "', '" . $newAuthor_nick . "', '" . $newAuthor_email . "', '0', '0',  '" . $newBody . "', '', NOW(), '' )";

      if($database->Query($sql))
      {
        $this->feedback .= "Hozzászólás elküldve.<br />";
        $this->saved = true;
      }
      else
      {
        $this->feedback .= _DATABASE_ERROR . '<br />';
      }

    }
  
  }

  
  function UpdatePost()
  {
    global $database;
    global $session;
    
    $id = intval($_GET['bejegyzes']);

    $newStatus = intval($_POST['gb_status']);
    $newAnswer_body = trim(htmlspecialchars($_POST['gb_answer_body']));
    $newModerator_id = $session->user[id];
    
    $sql = "UPDATE " . TBL_GUESTBOOK
         . " SET status = '" . $newStatus . "', answer_body = '" . $newAnswer_body . "', moderator_id = '" . $newModerator_id . "', answered = NOW()"
         . " WHERE id = '" . $id . "'"
         . " LIMIT 1";
         
    if($database->Query($sql))
    {
      $this->feedback .= "Módosítsáok sikeresen végrehajtva.<br />";
      $this->saved = true;
    }
    else
    {
      $this->feedback .= _DATABASE_ERROR . '<br />';
    }
    
  }
  
  function DeletePost()
  {
    global $database;
    
    $id = intval($_GET['bejegyzes']);

    $sql = "DELETE FROM " . TBL_GUESTBOOK
         . " WHERE id = '" . $id . "'"
         . " LIMIT 1";
  
    if($database->Query($sql))
    {
      $this->feedback .= "Bejegyzés sikeresen törölve.<br />";
      $this->saved = true;
    }
    else
    {
      $this->feedback .= _DATABASE_ERROR . '<br />';
    }
    
  }
  
  function GetFormURL($id = 0)
  {
    $url = $_SERVER['PHP_SELF'];
    
    if($id != 0)
    {
      $url .= "?bejegyzes=" . $id;
    }
    elseif($this->id != 0)
    {
      $url .= '?bejegyzes=' . $this->id;
    }

    return $url;
  }

  function CountNewPosts()
  {
    global $database;
    
    $sql = "SELECT COUNT(*)"
         . " FROM " . TBL_GUESTBOOK
         . " WHERE status = '0'";
         
    if($database->Query($sql) && ($row = $database->FetchRow()))
    {
      return $row[0];
    }
    else return false;
    
  }  
  
}

$guestbook = new bwGuestbook();

?>
