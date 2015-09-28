<?php

if(!defined("BW_APPLICATION"))
{
  die("Direct access to this internal component is forbidden.");
}

class bwClasstype {

  var $id;

  var $item = array();
  
  var $classtype = array();
  var $special = array();
  
  var $saved;
  var $feedback;
  
  function bwClasstype()
  {
    global $session;
  
    if(isset($_GET['ora']))
    {
      $this->id = ($this->Exists($_GET['ora'])) ? intval($_GET['ora']) : 0;
    }
    else
    {
      $this->id = 0;
    }
  
    $this->LoadInstructors();
  
    $this->saved = false;
    $this->feedback = '';
    
    if(isset($_POST['formId']) && ($session->GetUserLevel() >= bwSession::EDITOR))
    {
      switch($_POST['formId'])
      {
        case 'CLASSTYPE:UPDATE':
          $this->Update();
        break;
        case 'CLASSTYPE:DELETE':
          $this->DeleteClassType(htmlspecialchars($_POST['id']));
        break;
      }
      
    }
    
    $this->LoadClassTypes();
    
  }
  
  function LoadClassTypes()
  {
    global $database;
    
    if(isset($_GET['uj']) || (isset($_POST['formId']) && ($_POST['formId'] == 'CLASSTYPE:UPDATE')))
    {
      $this->item[0] = array('id' => '',
                              'title' => htmlspecialchars($_POST['class_title']), 
                              'body' => htmlspecialchars($_POST['class_body']),
                              'active' => htmlspecialchars($_POST['class_active'])
                             );
    }
    elseif($this->id == 0)
    {
    
      $sql = "SELECT *"
           . " FROM " . TBL_CLASSTYPE
           . " ORDER BY title ASC ";
           
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
           . " FROM " . TBL_CLASSTYPE
           . " WHERE id = '" . $this->id . "'"
           . " LIMIT 1 ";
      
      if($database->Query($sql) && ($row = $database->FetchRow()))
      {
        $this->item[0] = $row;
        $this->item[0]['classes'] = array();
        $this->item[0]['classes']['1'] = $this->LoadClassTypeClasses($this->id, 1);
        $this->item[0]['classes']['2'] = $this->LoadClassTypeClasses($this->id, 2);
      }
    
    }
  }

  function LoadInstructors()
  {
    global $database;
    
    //dummy
  }
  
  function LoadClassTypeClasses($id, $week)
  {
    global $database;
    
    $sql = "SELECT c.*, i.nick "
         . " FROM " . TBL_CLASS . " c, " . TBL_INSTRUCTOR . " i"
         . " WHERE c.classtype_id = '" . $id . "' AND c.week = '" . $week . "' AND c.instructor_id = i.id "
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
  
  function LoadSpecials()
  {
    $this->special[0] = '';
    $this->special[1] = 'uj';
    $this->special[2] = 'special';
    $this->special[3] = 'pot';
  }
  
  function Exists($id)
  {
    global $database;
  
    $sql = "SELECT *"
         . " FROM " . TBL_CLASSTYPE
         . " WHERE id = '" . $id . "'"
         . " LIMIT 1";
  
    return ($database->Query($sql) && (mysql_num_rows($database->GetResource())>0));
  }
    
  function TitleExists($title)
  {
    global $database;
  
    $sql = "SELECT *"
         . " FROM " . TBL_CLASSTYPE
         . " WHERE title = '" . $title . "'"
         . " LIMIT 1";
  
    return ($database->Query($sql) && (mysql_num_rows($database->GetResource())>0));
  }
    
  function Update()
  {
    $newTitle = htmlspecialchars($_POST['class_title']);
    $newBody = htmlspecialchars($_POST['class_body']);
    $newActive = htmlspecialchars($_POST['class_active']);
    
    if($newTitle == '')
    {
      $this->feedback = 'A név mezo nem lehet üres!';
    }
    else
    {
      if($this->id)
      {
        $this->UpdateOld($this->id, $newTitle, $newBody, $newActive);
      }
      else
      {
        $this->InsertNew($newTitle, $newBody, $newActive);
      }
    }
  }  

  function InsertNew($title, $body, $active)
  {
    global $database;
    
    if($this->TitleExists($title))
    {
      $this->feedback .= "Új óratípus létrehozása sikertelen. <strong>Név már létezik</strong>. Válassz másik nevet.<br />";
    }
    else
    {
      $sql = "INSERT INTO " . TBL_CLASSTYPE
           . " ( `id` , `title` , `body` , `active` )"
           . " VALUES ('', '" . $title . "', '" . $body . "', '" . $active . "' )";
  
      if($database->Query($sql))
      {
        $this->feedback .= "Új óratípus sikeresen létrehozva.<br />";
        $this->saved = true;
      }
      else
      {
        $this->feedback .= _DATABASE_ERROR . '<br />';
      }
    
    }
  }
  
  function UpdateOld($id, $title, $body, $active)
  {
    global $database;
    
    $sql = "SELECT * FROM " . TBL_CLASSTYPE
         . " WHERE id = '" . $id . "'"
         . " LIMIT 1";
         
    if($database->Query($sql) && ($row = $database->FetchRow()))
    {
      if(($title != $row['title']) && ($this->TitleExists($title)))
      {
        $this->feedback .= "Adatok módosítása sikertelen: ilyen <strong>név már létezik</strong>.<br />";
      }
      else
      {
        $sql = "UPDATE " . TBL_CLASSTYPE
             . " SET  title = '" . $title . "', body = '" . $body . "', active = '" . $active . "'"
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
  
  function DeleteClassType($id)
  {
    global $database;
    
    $sql = "DELETE FROM " . TBL_CLASSTYPE
         . " WHERE id = '" . $id . "'"
         . " LIMIT 1";
  
    if($database->Query($sql))
    {
      $this->feedback .= "Óratípus sikeresen törölve.<br />";
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
      $url .= "?ora=" . $id;
    }
    elseif($this->id != 0)
    {
      $url .= '?ora=' . $this->id;
    }

    return $url;
  }
  
  function CountClasses($classId = 0, $week = 1)
  {
    global $database;

    if($classId == 0) $classId = $this->id;

    $sql = "SELECT COUNT(*) FROM " . TBL_CLASS
         . " WHERE week = '" . $week . "' AND classtype_id = '" . $classId . "'";
    
    if($database->Query($sql) && ($row = $database->FetchRow()))
    {
      return $row[0];
    }
    else return 0;
    
  }
  
  function IsImageUploaded()
  {
    return false;
  }
  
}

$classtype = new bwClasstype();

?>
