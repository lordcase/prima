<?php

if(!defined("BW_APPLICATION"))
{
  die("Direct access to this internal component is forbidden.");
}

require_once('inc/bwSchedule.php');
require_once('inc/bwGuestbook.php');

class bwControlcenter {

  var $criticalTask;
  var $secondaryTask;
  var $guestbookEventLog;

  function bwControlcenter()
  {
    global $schedule;
    global $guestbook;
	global $session;
  
    $this->criticalTask = array();
    $this->secondaryTask = array();

    if($schedule->CountClasses(1, 1) == 0) $this->criticalTask[] = "Rexona aerobic terem eheti <a href=\"orarend2.php\">órarendje</a> üres.";
    if($schedule->CountClasses(1, 2) == 0) $this->criticalTask[] = "Vitalade aerobic - spinning terem eheti <a href=\"orarend2.php\">órarendje</a> üres.";

    if($schedule->CountClasses(2, 1) == 0) $this->secondaryTask[] = "Rexona aerobic terem jövõheti <a href=\"orarend2.php\">órarendje</a> üres.";
    if($schedule->CountClasses(2, 2) == 0) $this->secondaryTask[] = "Vitalade aerobic - spinning terem jövõheti <a href=\"orarend2.php\">órarendje</a> üres.";
    
    if(($schedule->CountClasses(2, 1) > 0) && ($schedule->CountClasses(2, 2) > 0) && ($schedule->GetStatus() == false)) $this->secondaryTask[] = "Jövõheti <a href=\"orarend2.php\">órarendek</a> nincsenek publikálva.";


    if(count($this->criticalTask) < 1) $this->criticalTask[] = "Jelenleg nincsenek kritikus feladatok";
    if(count($this->secondaryTask) < 1) $this->secondaryTask[] = "Jelenleg nincsenek másodlagos fontosságú feladatok";

  }

}

$controlcenter = new bwControlcenter;

?>
