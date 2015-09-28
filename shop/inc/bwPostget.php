<?php

class bwPostget {

  function bwPostget()
  {
    //dummy
  }

  function iitem($id)
  {
    return false;
  }

  function Item($id, $default = '')
  {
    $item = $this->iitem($id);
    return ($item === false) ? $default : $item; 
  }

  function isEmail($id)
  {
   $item = $this->iitem($id);
   return (preg_match( "/^[\d\w\/+!=#|$?%{^&}*`'~-][\d\w\/\.+!=#|$?%{^&}*`'~-]*@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i", $item) > 0);
  }
  
}

class bwGet extends bwPostget {

  function iitem($id)
  {
    return isset($_GET[$id]) ? $_GET[$id] : false;
  }
}

class bwPost extends bwPostget {

  var $toModule;
  var $toFunction;

  function bwPost()
  {
    if(isset($_POST['formId']))
    {
      $dummy = split(':', $_POST['formId']);
      if(sizeof($dummy) == 2)
      {
        $this->toModule = strtoupper($dummy[0]);
        $this->toFunction = strtoupper($dummy[1]);
      }
      else
      {
        $this->toModule = false;
        $this->toFunction = false;
      }
    }
  }

  function iitem($id)
  {
    return isset($_POST[$id]) ? $_POST[$id] : false;
  }

}

$GET = new bwGet();
$POST = new bwPost();

?>
