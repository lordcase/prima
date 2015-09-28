<?php

require_once('inc/class.phpmailer.php');

if(!defined("BW_APPLICATION"))
{
  die("Direct access to this internal component is forbidden.");
}

define('BW_GUESTBOOK_PAGESIZE', 10);

class bwGuestbook {

  var $id;
  var $page;
	var $total;
	var $lastPage;
	var $postNumberToShow;

  var $limit;

  var $item = array();
  
  var $saved;
  var $feedback;
	var $recentOnly;
  
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
    
		$this->recentOnly = false;
		
    if(isset($_POST['formId']))
    {
      switch($_POST['formId'])
      {
        case 'GUESTBOOK:POST':
          $this->PostNew();
        break;
        case 'GUESTBOOK:UPDATE':
          if($session->GetUserLevel() >= bwSession::MODERATOR) $this->UpdatePost();
        break;
        case 'GUESTBOOK:DELETE':
          if($session->GetUserLevel() >= bwSession::MODERATOR) $this->DeletePost();
        break;
        case 'GUESTBOOK:UNDELETE':
          if($session->GetUserLevel() >= bwSession::SUPER_MODERATOR) $this->UndeletePost();
        break;
        case 'GUESTBOOK:SENDEMAIL':
          if($session->GetUserLevel() >= bwSession::MODERATOR) $this->SendAnswerEmail();
        break;
      }
      
    }
    
    //$this->LoadPosts();
    
  }
  
  // folder csak editmode = 1 esetén bír jelentéssel. ha folder = 0, 1, 2, vagy 3, akkor csak az adott státuszúakat tölti be. Ha folder = 4, akkor mindet betölti, aminek nem 3 (törölt) a státusza.
  function LoadPosts($editmode = 0, $folder = 4)
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
    
			$this->total = $this->CountEntries($editmode);
			$this->lastPage = intval($this->total / BW_GUESTBOOK_PAGESIZE) + (($this->total % BW_GUESTBOOK_PAGESIZE) ? 1 : 0);
			if($this->lastPage == 0)
			{
				$this->lastPage = 1;
			}
			
			if(isset($_GET['oldal']))
			{
				$this->page = intval($_GET['oldal']);
				if($this->page < 1)
				{
					$this->page = 1;
				}
				if($this->page > $this->lastPage)
				{
					$this->page = $this->lastPage;
				}
			}
			else
			{
				$this->page = $this->lastPage;
			}
		
			$firstPost = ($this->lastPage - $this->page) * BW_GUESTBOOK_PAGESIZE;
		
			$this->postNumberToShow = $this->total - ($this->lastPage - $this->page) * BW_GUESTBOOK_PAGESIZE;
		
      if($editmode)
      {
	  	if (($folder == 0) || ($folder == 1) || ($folder == 2) || ($folder == 3))
		{
			$sql = "SELECT *"
				 . " FROM " . TBL_GUESTBOOK
				 . " WHERE status = '" . $folder . "'"
				 . " ORDER BY status, created DESC ";
			$this->recentOnly = false;
		}
		else
		{
			$sql = "SELECT *"
				 . " FROM " . TBL_GUESTBOOK
				 . " WHERE status <> '3'"
				 . " ORDER BY status, created DESC ";
			$this->recentOnly = false;
		}
      }
      elseif(isset($_GET['osszes']))
      {
        $sql = "SELECT *"
             . " FROM " . TBL_GUESTBOOK
             . " WHERE status = '2'"
             . " ORDER BY created DESC ";
				$this->recentOnly = false;
      }
      else
      {
        $sql = "SELECT *"
             . " FROM " . TBL_GUESTBOOK
             . " WHERE status = '2'"
             . " ORDER BY created DESC "
						 . " LIMIT " . $firstPost . ", " . BW_GUESTBOOK_PAGESIZE;
				$this->recentOnly = true;
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
              $row['author_email'] = $userRow['email'];  
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
             $row['author_email'] = $userRow['email'];  
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


	function CountEntries($editmode = 0)
	{
		global $database;
	
		if($editmode)
		{
			$sql = "SELECT COUNT(*)"
					 . " FROM " . TBL_GUESTBOOK
					 . " WHERE status <> '4'";
		}
		else
		{
			$sql = "SELECT COUNT(*)"
					 . " FROM " . TBL_GUESTBOOK
					 . " WHERE status = '2'";
    }

    if($database->Query($sql) && ($row = $database->FetchRow()))
		{
			return $row[0];
		}
		else
		{
		  return 0;
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

  	if( (substr_count($newBody, 'http:') >= 1)
     || (substr_count($newBody, 'www.') >= 1)
     || (substr_count($newBody, '.com') >= 1)
     || (substr_count($newBody, '.org') >= 1)
     || (substr_count($newBody, '.hu') >= 1)
     || (substr_count($newBody, 'http:') >=1)
    )
    {
      $this->feedback .= 'Az üzenet spam-szûrési okokból nem tartalmazhat www címeket!<br />';
    }
    
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
	  $this->LogGuestbookEvent($id, $newModerator_id, 1, $newAnswer_body, $newStatus);
      $this->feedback .= "Módosítások sikeresen végrehajtva.<br />";
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
	global $session;
    
    $id = intval($_GET['bejegyzes']);

	/*
    $sql = "DELETE FROM " . TBL_GUESTBOOK
         . " WHERE id = '" . $id . "'"
         . " LIMIT 1";
	*/

    $newModerator_id = $session->user[id];

    $sql = "UPDATE " . TBL_GUESTBOOK
         . " SET status = '3', moderator_id = '" . $newModerator_id . "', answered = NOW()"
         . " WHERE id = '" . $id . "'"
         . " LIMIT 1";

  
    if($database->Query($sql))
    {
	  $this->LogGuestbookEvent($id, $newModerator_id, 3, '', 0);
      $this->feedback .= "Bejegyzés sikeresen törölve.<br />";
      $this->saved = true;
    }
    else
    {
      $this->feedback .= _DATABASE_ERROR . '<br />';
    }
    
  }
  
  function UndeletePost()
  {
    global $database;
	global $session;
    
    $id = intval($_GET['bejegyzes']);

    $newModerator_id = $session->user[id];

    $sql = "UPDATE " . TBL_GUESTBOOK
         . " SET status = '1', moderator_id = '" . $newModerator_id . "', answered = NOW()"
         . " WHERE id = '" . $id . "'"
         . " LIMIT 1";

  
    if($database->Query($sql))
    {
	  $this->LogGuestbookEvent($id, $newModerator_id, 4, '', 0);
      $this->feedback .= "Bejegyzés sikeresen visszaállítva.<br />";
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

  function LogGuestbookEvent($guestbook_id, $moderator_id, $type, $body, $status)
  {
    global $database;
    
    $sql = "INSERT INTO " . TBL_GUESTBOOK_EVENT
         . " ( `id` , `guestbook_id` , `user_id` , `created`, `type` , `body` , `status` )"
         . " VALUES ('', '" . $guestbook_id . "', '" . $moderator_id . "', NOW(), '" . $type . "', '" . $body . "',  '" . $status . "' )";
		 
    if($database->Query($sql))
    {
		return true;
    }
    else
    {
		return false;
    }
  }
  
  function GetLatestEventLog()
  {
  	global $database;
  
	$fromDate = date('Y-m-d 00:00:00', time() - 7 * 24 * 60 * 60);

	$sql = "SELECT e.*, g.title, g.author_nick, g.status AS current_status, u.nick, u.email"
		 . " FROM " . TBL_GUESTBOOK_EVENT . " e, " .  TBL_GUESTBOOK. " g, " . TBL_USER . " u "
		 . " WHERE e.guestbook_id = g.id AND e.user_id = u.id AND e.created >= '" . $fromDate . "' "
		 . " ORDER BY created DESC ";

	if ($database->Query($sql))
	{
		$events = array();
	
		$res = $database->GetResource();
		
		while($row = mysql_fetch_array($res))
		{
			$events[] = $this->GetComputedFieldsForEvent($row);
		}
		
		return $events;
    }
    else
    {
		return false;
    }
  }
  
  function GetEventLogForItem($id)
  {
  	global $database;
  
	$sql = "SELECT e.*, g.title, g.author_nick, g.status AS current_status, u.nick, u.email"
		 . " FROM " . TBL_GUESTBOOK_EVENT . " e, " .  TBL_GUESTBOOK. " g, " . TBL_USER . " u "
		 . " WHERE e.guestbook_id = g.id AND e.user_id = u.id AND e.guestbook_id = '" . $id . "' "
		 . " ORDER BY created DESC ";

	if ($database->Query($sql))
	{
		$events = array();
	
		$res = $database->GetResource();
		
		while($row = mysql_fetch_array($res))
		{
			$events[] = $this->GetComputedFieldsForEvent($row);
		}
		
		return $events;
    }
    else
    {
		return false;
    }
  }
  
  function GetComputedFieldsForEvent($row)
  {
	switch ($row['type'])
	{
		case 1:
			$row['type_text'] = 'Válasz és/vagy státusz módosítás';
			break;
		case 2:
			$row['type_text'] = '<strong>Válasz emailben</strong>';
			break;
		case 3:
			$row['type_text'] = '<strong>Törlés</strong>';
			break;
		case 4:
			$row['type_text'] = 'Törlés visszavonása';
			break;
		default:
			$row['type_text'] = 'nincs definiálva';
			break;
	}
	
	return $row;
	
  }
  
  function GetEmailBody()
  {
  	return htmlspecialchars(trim($_POST['gb_email_body']));
  }
  function GetEmailSenderName()
  {
  	return "CBA Fintess & Wellness Line";
  }

  function GetEmailSenderAddress()
  {
  	return "info@cbafitness.hu";
  }

  function GetEmailSubject()
  {
    if (isset($this->item[0]))
	{
	  	return "Re: " . $this->item[0]['title'];
	}
	else
	{
		return "Üzenet a CBA Fitnesstõl";
	}
  }

	function SendAnswerEmail()
	{
	
		global $session;
		
		$this->LoadPosts();
		
		if($this->id > 0)
		{
			
			$from = array('name' => $this->GetEmailSenderName(), 'email' => $this->GetEmailSenderAddress());
			$to = array('name' => $this->item[0]['author_nick'], 'email' => $this->item[0]['author_email']);
			$subject = $this->GetEmailSubject();
			$body = $this->GetEmailBody();
	
			if (strlen($body) < 20)
			{
				$this->feedback .= 'Az email szövege legalább 20 karakter hosszú kell hogy legyen!<br />';
			}
			else
			{
				$this->feedback .= 'Az email sikeresen elküldve.';
				if ($this->SendMail($from, $to, $subject, $body))
				{
				  $newModerator_id = $session->user[id];
			
				  $this->LogGuestbookEvent($this->id, $newModerator_id, 2, $body, $this->item[0]['status']);
				  $this->saved = true;
				}
				else
				{
				  $this->feedback .= 'Az email küldése során hiba lépett fel!<br />';
				}
			}
		}
	}
	
	// generic mail method
	function SendMail($from, $to, $subject, $body)
	{
		$mailer = new PHPMailer();
	
		$mailer->IsSMTP();
		$mailer->CharSet = 'iso-8859-2';
		$mailer->IsHTML(false);
		$mailer->Host = "127.0.0.1";
		$mailer->Subject = $subject;
		$mailer->Body = $body;
		$mailer->From = $from['email'];
		$mailer->FromName = $from['name'];
		$mailer->AddAddress($to['email'], $to['name']);
		
		return $mailer->Send();
	}
  
}

$guestbook = new bwGuestbook();

?>
