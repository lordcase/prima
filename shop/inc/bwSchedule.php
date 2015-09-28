<?php

if(!defined("BW_APPLICATION"))
{
  die("Direct access to this internal component is forbidden.");
}

class bwSchedule {

  var $week;
  var $room;

  var $item = array();
  var $classtype = array();
  var $instructor = array();
  
  var $special = array();
  
  var $saved;
  
  function bwSchedule()
  {
    global $session;
  
    $this->week = isset($_GET['jovohet']) ? 2 : 1;
    if(isset($_GET['terem']))
    {
      $this->room = (($_GET['terem'] == 1) || ($_GET['terem'] == 2)) ? intval($_GET['terem']) : 0;
    }
    else
    {
      $this->room = 0;
    }
  
    $this->LoadInstructors();
    $this->LoadClassTypes();
    $this->LoadSpecials();
    
    $this->saved = false;
    
    
    if(isset($_POST['formId']) && ($session->GetUserLevel() >= bwSession::EDITOR))
    {
      switch($_POST['formId'])
      {
        case 'SCHEDULE:UPDATE':
          if($this->room != 0) $this->UpdateSchedule();
        break;
        case 'SCHEDULE:PUBLICATE':
          $this->PublicateSchedule();
        break;
        case 'SCHEDULE:HIDE':
          $this->HideSchedule();
        break;
        case 'SCHEDULE:COPY':
          $this->CopySchedule(1, 2);
        break;
      }
      
    }
    
    $this->NextWeekIfTime();
    
    $this->LoadClasses();
  }
  
  function LoadClasses()
  {
    global $database;

    $sql = "SELECT c.*, i.active AS instructor_active, t.active AS classtype_active "
         . " FROM " . TBL_CLASS . " c, " . TBL_INSTRUCTOR . " i, " . TBL_CLASSTYPE . " t "
         . " WHERE week = '" . $this->week . "' AND c.instructor_id = i.id AND c.classtype_id = t.id ";

    for($i = 1; $i<=2; $i++)
    {
      $this->item[$i] = array();
      for($j = 1; $j<=7; $j++)
      {
        $this->item[$i][$j] = array();
        for($k = 6; $k<=20; $k++)
        {
          $this->item[$i][$j][$k] = array(0=> 0, 1=> 0, 2=> 0);
        }
      }
    }     
    
    if($database->Query($sql))
    {
      while($row = $database->FetchRow())
      {
        $this->item[$row['room']][$row['day']][$row['hour']][0] = $row['instructor_id'];
        $this->item[$row['room']][$row['day']][$row['hour']][1] = $row['classtype_id'];
        $this->item[$row['room']][$row['day']][$row['hour']][2] = $row['special'];
        $this->item[$row['room']][$row['day']][$row['hour']]['instructor_active'] = $row['instructor_active'];
        $this->item[$row['room']][$row['day']][$row['hour']]['classtype_active'] = $row['classtype_active'];
      }
    }

  }
  
  function LoadInstructors()
  {
    global $database;
    
    $sql = "SELECT id, nick "
         . " FROM " . TBL_INSTRUCTOR
         //. " WHERE active = '1' "
         . " ORDER BY nick ASC ";
         
    $this->instructor[0] = '';

    if($database->Query($sql))
    {
      while($row = $database->FetchRow())
      {
        $this->instructor[$row['id']] = $row['nick'];
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
    $this->special[4] = 'special2';
  }
  
  function IsClassSetInDB($room, $day, $hour)
  {
    global $database;
  
    $sql = "SELECT * "
         . " FROM " . TBL_CLASS
         . " WHERE week = '" . $this->week . "' AND room = '" . $room . "' AND day = '" . $day . "' AND hour = '" . $hour . "'"
         . " LIMIT 1";

    return ($database->Query($sql) && (mysql_num_rows($database->GetResource())>0));

  }
  
  function UpdateSchedule()
  {
    global $session;
    
    if($session->GetUserLevel() >= bwSession::EDITOR)
    {
      for($day=1; $day<=7; $day++)
      {
        for($hour=6; $hour<=20; $hour++)
        {
          $inputId = 'bwei' . $this->room . '_' . $day . '_' . $hour;
          if(isset($_POST[$inputId . 'changed']) && ($_POST[$inputId . 'changed'] == '1'))
          {
            $instrId = $_POST[$inputId . 'instr'];
            $classId = $_POST[$inputId . 'class'];
            $specialId = $_POST[$inputId . 'special'];
            
            if(isset($this->instructor[$instrId]) && isset($this->classtype[$classId]) && isset($this->special[$specialId]))
            {
              if(($instrId != 0) || ($classId != 0))
              {
                $this->UpdateClass($this->room, $day, $hour, $instrId, $classId, $specialId);
              }
              else
              {
                $this->DeleteClass($this->room, $day, $hour);
              }
            }
          }      
        }
      }
      $this->saved = true;
    }
  }
  
  function UpdateClass($room, $day, $hour, $instrId, $typeId, $specialId)
  {
    if($this->IsClassSetInDB($room, $day, $hour))
    {
      $this->UpdateOldClass($room, $day, $hour, $instrId, $typeId, $specialId);
    }
    else
    {
      $this->InsertNewClass($room, $day, $hour, $instrId, $typeId, $specialId);
    }
  }  

  function DeleteClass($room, $day, $hour)
  {
    global $database;
    
    $sql = "DELETE FROM " . TBL_CLASS
         . " WHERE week = '" . $this->week . "' AND room = '" . $room . "' AND day = '" . $day . "' AND hour = '" . $hour . "'"
         . " LIMIT 1";
  
    $database->Query($sql); 
  }
  
  function InsertNewClass($room, $day, $hour, $instrId, $typeId, $specialId)
  {
    global $database;

    $sql = "INSERT INTO " . TBL_CLASS
         . " ( `week` , `room` , `day` , `hour` , `instructor_id` , `classtype_id` , `special` )"
         . " VALUES ('" . $this->week . "', '" . $room . "', '" . $day . "', '" . $hour  . "', '" . $instrId . "', '" . $typeId . "', '" . $specialId . "' )";

    $database->Query($sql); 
  }
  
  function UpdateOldClass($room, $day, $hour, $instrId, $typeId, $specialId)
  {
    global $database;
    
    $sql = "UPDATE " . TBL_CLASS
         . " SET instructor_id = '" . $instrId . "', classtype_id = '" . $typeId . "', special = '" . $specialId . "'"
         . " WHERE week = '" . $this->week . "' AND room = '" . $room . "' AND day = '" . $day . "' AND hour = '" . $hour . "'"
         . " LIMIT 1";
         
    $database->Query($sql); 
  }
  
  function CopySchedule($from, $to)
  {
    global $database;

    $this->DeleteSchedule($to);

    $sql = "SELECT * "
         . " FROM " . TBL_CLASS
         . " WHERE week = '" . $from . "' ";
         
    if($database->Query($sql) && ($resource = $database->GetResource()))
    {
      while($row = mysql_fetch_array($resource))
      {
        $sql = "INSERT INTO " . TBL_CLASS
             . " ( `week` , `room` , `day` , `hour` , `instructor_id` , `classtype_id` , `special` )"
             . " VALUES ('" . $to . "', '" . $row['room'] . "', '" . $row['day'] . "', '" . $row['hour']  . "', '" . $row['instructor_id'] . "', '" . $row['classtype_id'] . "', '" . $row['special'] . "' )";
    
        $database->Query($sql); 
      }    
    }
  }
  
  function MoveSchedule($from, $to)
  {
    $this->CopySchedule($from, $to);
    $this->DeleteSchedule($from);
  }
  
  function DeleteSchedule($week)
  {
    global $database;
    
    $sql = "DELETE FROM " . TBL_CLASS
         . " WHERE week = '" . $week . "'";
  
    $database->Query($sql); 
  }

  function PublicateSchedule()
  {
    global $status;

    $status->Set("SCHEDULE_PUBLIC", "1");
  }

  function HideSchedule()
  {
    global $status;

    $status->Set("SCHEDULE_PUBLIC", "0");
  }

  function NextWeekIfTime()
  {
    global $status;
    global $log;
    
    $thisWeek = intval(date('W'));
    $lastUpdatedWeek = intval($status->Get('SCHEDULE_LAST_UPDATE_WEEK'));
    
    if($thisWeek != $lastUpdatedWeek)
    {
      if($status->Set('SCHEDULE_LAST_UPDATE_WEEK', $thisWeek))
      {
        $status->Set('TEMP_SCHEDULE_UPDATE' . time(), date('Y-m-d D H:i:s'));
        $log->Log('bwSchedule', 'Órarend hétváltás.'  , BW_LOG_LOW);
        $this->NextWeek();
      }
    }
  }

  function NextWeek()
  {
    $this->MoveSchedule(2, 1);
    $this->HideSchedule();
  }

  function GetWeekName()
  {
    $t = time();
    if($this->week == 2) $t+= 60 * 60 * 24 * 7; 
  
    $wd = intval(date('w', $t));
    if($wd==0) $wd = 7;
    
    $t1 = $t - ($wd-1) * 60 * 60 * 24;
    $t7 = $t + (7-$wd) * 60 * 60 * 24;
    
    $weekname = strftime('%B %e', $t1) . ' - ' . strftime('%B %e', $t7);
    
    return $weekname;
    
    //return ($this->week==2) ? "Jövõhét" : "Mostani hét";
  }
           
  function GetClassInstructorId($room, $day, $hour)
  {
    return $this->item[$room][$day][$hour][0];
  }

  function GetClassClassTypeId($room, $day, $hour)
  {
    return $this->item[$room][$day][$hour][1];
  }

  function GetClassSpecialId($room, $day, $hour)
  {
    return $this->item[$room][$day][$hour][2];
  }

  function GetClassLabel($room, $day, $hour)
  {
    $instr_html = $this->instructor[$this->GetClassInstructorId($room, $day, $hour)];
    $ctype_html = $this->classtype[$this->GetClassClassTypeId($room, $day, $hour)];
  
    return  $instr_html . '<br />' . $ctype_html; 
  }

  function GetActiveClassLabel($room, $day, $hour)
  {
    $instr_html = $this->instructor[$this->GetClassInstructorId($room, $day, $hour)];
    $ctype_html = $this->classtype[$this->GetClassClassTypeId($room, $day, $hour)];
    
    if($this->item[$room][$day][$hour]['instructor_active'])
    {
      $instr_html =  "<a href=\"edzo.php?edzo=" . $this->GetClassInstructorId($room, $day, $hour) . "\">" . $instr_html . "</a>";
    }
    
    if($this->item[$room][$day][$hour]['classtype_active'])
    {
      $ctype_html =  "<a href=\"oratipus.php?ora=" . $this->GetClassClassTypeId($room, $day, $hour) . "\">" . $ctype_html . "</a>";
    }
    
    return  $instr_html . '<br />' . $ctype_html; 
  }

  function GetClassSpecialLabel($room, $day, $hour)
  {
    return $this->special[$this->GetClassSpecialId($room, $day, $hour)];
  }
  
  function GetFormURL($week = 0, $room = 0)
  {
    if(($week != 1) && ($week != 2)) $week = $this->week;
    if(($room != 1) && ($room != 2)) $room = $this->room;
  
    $url = $_SERVER['PHP_SELF'] . '?terem=' . $room;
    if($week == 2)
    {
      $url .= "&jovohet";
    }
    
    return $url;
  }
  
  function GetStatus()
  {
    global $status;

    return ($status->Get("SCHEDULE_PUBLIC") == '1');
  }
  
  function GetStatusLabel()
  {
    return $this->GetStatus() ? "publikálva" : "rejtve";
  }
  
  function CountClasses($week = 0, $room = 0)
  {
    global $database;

    if(($week != 1) && ($week != 2)) $week = $this->week;
    if(($room != 1) && ($room != 2)) $room = $this->room;
    
    $sql = "SELECT COUNT(*) FROM " . TBL_CLASS
         . " WHERE week = '" . $week  . "' AND room = '" . $room . "'";
    
    if($database->Query($sql) && ($row = $database->FetchRow()))
    {
      return $row[0];
    }
    else return 0;
    
  }
	
	function GetPrintURL()
	{
    return 'orarend_print.php' . (($this->week == 2) ? '?jovohet' : '');
	}
  
}

$schedule = new bwSchedule();

?>