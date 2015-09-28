<?php

if(!defined("BW_APPLICATION"))
{
  die("Direct access to this internal component is forbidden.");
}

class bwInstructor {

  var $id;
	var $type; // 0 = mind; 1 = aerobic edzõk; 2 = fitness (személyi) edzõk

  var $item = array();
  
  var $classtype = array();
  var $special = array();
  
  var $saved;
  var $feedback;
  
  function bwInstructor()
  {
    global $session;
  
    if(isset($_GET['edzo']))
    {
      $this->id = ($this->Exists($_GET['edzo'])) ? intval($_GET['edzo']) : 0;
			$this->type = 0;
    }
    elseif (isset($_GET['aerobic']))
    {
      $this->id = 0;
			$this->type = 1;
    }
    elseif (isset($_GET['fitness']))
    {
      $this->id = 0;
			$this->type = 2;
    }
		else
		{
      $this->id = 0;
			$this->type = 0;
		}
  
    $this->LoadClassTypes();
  
    $this->saved = false;
    $this->feedback = '';
    
    if(isset($_POST['formId']) && ($session->GetUserLevel() >= bwSession::EDITOR))
    {
      switch($_POST['formId'])
      {
        case 'INSTRUCTOR:UPDATE':
          $this->Update();
        break;
        case 'INSTRUCTOR:DELETE':
          $this->DeleteInstructor(htmlspecialchars($_POST['id']));
        break;
      }
      
    }
    
    $this->LoadInstructors();
    
  }
  
  function LoadInstructors()
  {
    global $database;
    
    if(isset($_GET['uj']) || (isset($_POST['formId']) && ($_POST['formId'] == 'INSTRUCTOR:UPDATE')))
    {
      $this->item[0] = array('id' => '',
                              'nick' => htmlspecialchars($_POST['instr_nick']), 
                              'name' => htmlspecialchars($_POST['instr_name']),
                              'slogan' => htmlspecialchars($_POST['instr_slogan']),
                              'body' => htmlspecialchars($_POST['instr_body']),
                              'active' => htmlspecialchars($_POST['instr_active']),
                              'is_aerobic' => htmlspecialchars($_POST['instr_is_aerobic']),
                              'is_fitness' => htmlspecialchars($_POST['instr_is_fitness'])
                             );
    }
    elseif($this->id == 0)
    {
			if ($this->type == 1)
			{
				$sql = "SELECT *"
						 . " FROM " . TBL_INSTRUCTOR
						 . " WHERE is_aerobic = '1'"
						 . " ORDER BY nick ASC ";
			}
			elseif ($this->type == 2)
			{
				$sql = "SELECT *"
						 . " FROM " . TBL_INSTRUCTOR
						 . " WHERE is_fitness = '1'"
						 . " ORDER BY nick ASC ";
			}
			else
			{
				$sql = "SELECT *"
						 . " FROM " . TBL_INSTRUCTOR
						 . " ORDER BY nick ASC ";
			}
           
      if($database->Query($sql))
      {
        while($row = $database->FetchRow())
        {
          $this->item[] = $row;
        }
      }
    }
    else
    {
      $sql = "SELECT *"
           . " FROM " . TBL_INSTRUCTOR
           . " WHERE id = '" . $this->id . "'"
           . " LIMIT 1 ";
      
      if($database->Query($sql) && ($row = $database->FetchRow()))
      {
        $this->item[0] = $row;
        $this->item[0]['classes'] = array();
        $this->item[0]['classes']['1'] = $this->LoadInstructorClasses($this->id, 1);
        $this->item[0]['classes']['2'] = $this->LoadInstructorClasses($this->id, 2);
      }
    
    }
  }

  function LoadClassTypes()
  {
    global $database;
    
    $sql = "SELECT id, title "
         . " FROM " . TBL_CLASSTYPE
         //. " WHERE active = '1' "
         . " ORDER BY title ASC ";
    
    $this->classtype[0] = '';
    
    if($database->Query($sql))
    {
      while($row = $database->FetchRow())
      {
        $this->classtype[$row['id']] = $row['title'];
      }
    }

  }
  
  function LoadSpecials()
  {
    $this->special[0] = '';
    $this->special[1] = 'uj';
    $this->special[2] = 'special';
    $this->special[3] = 'pot';
  }
  
  function LoadInstructorClasses($id, $week)
  {
    global $database;
    
    $sql = "SELECT c.*, t.title "
         . " FROM " . TBL_CLASS . " c, " . TBL_CLASSTYPE . " t"
         . " WHERE c.instructor_id = '" . $id . "' AND c.week = '" . $week . "' AND c.classtype_id = t.id "
         . " ORDER BY c.day, c.hour ASC ";

    $classes = array();
    
    if($database->Query($sql))
    {
      while($row = $database->FetchRow())
      {
        $classes[] = $row;
      }
    }
    
    return $classes;
  }
  
  function Exists($id)
  {
    global $database;
  
    $sql = "SELECT *"
         . " FROM " . TBL_INSTRUCTOR
         . " WHERE id = '" . $id . "'"
         . " LIMIT 1";
  
    return ($database->Query($sql) && (mysql_num_rows($database->GetResource())>0));
  }
    
  function NickExists($nick)
  {
    global $database;
  
    $sql = "SELECT *"
         . " FROM " . TBL_INSTRUCTOR
         . " WHERE nick = '" . $nick . "'"
         . " LIMIT 1";
  
    return ($database->Query($sql) && (mysql_num_rows($database->GetResource())>0));
  }
    
  function Update()
  {
    $newNick = htmlspecialchars($_POST['instr_nick']);
    $newName = htmlspecialchars($_POST['instr_name']);
    $newSlogan = htmlspecialchars($_POST['instr_slogan']);
    $newBody = htmlspecialchars($_POST['instr_body']);
    $newActive = htmlspecialchars($_POST['instr_active']);
		
    $newIsAerobic = isset($_POST['instr_is_aerobic']) ? 1 : 0;
    $newIsFitness = isset($_POST['instr_is_fitness']) ? 1 : 0;
    
    if($newNick == '')
    {
      $this->feedback = 'A becenév mezõ nem lehet üres!';
    }
    else
    {
      if($this->id)
      {
        if(isset($_POST['instr_noimage']))
        {
          $this->DeleteImage($this->id);
        }
        $this->UpdateOld($this->id, $newNick, $newName, $newSlogan, $newBody, $newActive, $newIsAerobic, $newIsFitness);
      }
      else
      {
        $this->InsertNew($newNick, $newName, $newSlogan, $newBody, $newActive, $newIsAerobic, $newIsFitness);
      }
    }
  }  

  function InsertNew($nick, $name, $slogan, $body, $active, $isAerobic, $isFitness)
  {
    global $database;
    
		if (get_magic_quotes_gpc())
		{
			$nick = stripslashes($nick);
			$name = stripslashes($name);
			$slogan = stripslashes($slogan);
			$body = stripslashes($body);
		}
		
		$nick = mysql_real_escape_string($nick);
		$name = mysql_real_escape_string($name);
		$slogan = mysql_real_escape_string($slogan);
		$body = mysql_real_escape_string($body);
    
    if($this->NickExists($nick))
    {
      $this->feedback .= "Új edzõ létrehozása sikertelen. <strong>Becenév már létezik</strong>. Válassz másik becenevet.<br />";
    }
    else
    {
      $sql = "INSERT INTO " . TBL_INSTRUCTOR
           . " ( `id` , `nick` , `name` , `picture` , `slogan` , `body` , `active` , `is_aerobic` , `is_fitness` )"
           . " VALUES ('', '" . $nick . "', '" . $name . "', '', '" . $slogan . "', '" . $body . "', '" . $active . "', '" . $isAerobic. "', '" . $isFitness . "' )";
  
      if($database->Query($sql))
      {
        $this->feedback .= "Új edzõ sikeresen létrehozva.<br />";
        $this->saved = true;
      }
      else
      {
        $this->feedback .= _DATABASE_ERROR . '<br />';
      }
    
    }
  }
  
  function UpdateOld($id, $nick, $name, $slogan, $body, $active, $isAerobic, $isFitness)
  {
    global $database;
		
		if (get_magic_quotes_gpc())
		{
			$nick = stripslashes($nick);
			$name = stripslashes($name);
			$slogan = stripslashes($slogan);
			$body = stripslashes($body);
		}
		
		$nick = mysql_real_escape_string($nick);
		$name = mysql_real_escape_string($name);
		$slogan = mysql_real_escape_string($slogan);
		$body = mysql_real_escape_string($body);
    
    $sql = "SELECT * FROM " . TBL_INSTRUCTOR
         . " WHERE id = '" . $id . "'"
         . " LIMIT 1";
         
    if($database->Query($sql) && ($row = $database->FetchRow()))
    {
      if(($nick != $row['nick']) && ($this->NickExists($nick)))
      {
        $this->feedback .= "Adatok módosítása sikertelen: ilyen <strong>becenév már létezik</strong>.<br />";
      }
      else
      {
        $sql = "UPDATE " . TBL_INSTRUCTOR
             . " SET nick = '" . $nick . "', name = '" . $name . "', slogan = '" . $slogan . "', body = '" . $body . "', active = '" . $active . "', is_aerobic = '" . $isAerobic . "', is_fitness = '" . $isFitness . "'"
             . " WHERE id = '" . $id . "'"
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
    else
    {
      $this->feedback .= _DATABASE_ERROR . '<br />';
    }
    
  }
  
  function DeleteInstructor($id)
  {
    global $database;
    
    $sql = "DELETE FROM " . TBL_INSTRUCTOR
         . " WHERE id = '" . $id . "'"
         . " LIMIT 1";
  
    if($database->Query($sql))
    {
      $this->feedback .= "Edzõ sikeresen törölve.<br />";
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
    
    if(isset($_GET['uj']))
    {
      $url .= "?uj";
    }
    elseif($id != 0)
    {
      $url .= "?edzo=" . $id;
    }
    elseif($this->id != 0)
    {
      $url .= '?edzo=' . $this->id;
    }

    return $url;
  }
  
  function CountClasses($instrId = 0, $week = 1)
  {
    global $database;

    if($instrId == 0) $instrId = $this->id;

    $sql = "SELECT COUNT(*) FROM " . TBL_CLASS
         . " WHERE week = '" . $week . "' AND instructor_id = '" . $instrId . "'";
    
    if($database->Query($sql) && ($row = $database->FetchRow()))
    {
      return $row[0];
    }
    else return 0;
    
  }
 
  function IsImageUploaded($id)
  {
    return file_exists('img/content/edzok/edzo' . $id . '.jpg');
  }
  
  function GetImageURL($id)
  {
    if($this->IsImageUploaded($id))
    {
      $return = 'img/content/edzok/edzo' . $id . '.jpg';
    }
    else
    {
      $return = 'img/content/edzok/noimage.jpg';
    }

    return $return;
  }

  function GetThumbnailURL($id)
  {
    if($this->IsImageUploaded($id))
    {
      $return = 'img/content/edzok/edzo' . $id . '_tn.jpg';
    }
    else
    {
      $return = 'img/content/edzok/noimage.jpg';
    }
    
    return $return;
  }
  
  function DeleteImage($id)
  {
    if($this->IsImageUploaded($id))
    {
      unlink($this->GetThumbnailURL($id));
      unlink($this->GetImageURL($id));
    }
  }
  
}

$instructor = new bwInstructor();

?>
