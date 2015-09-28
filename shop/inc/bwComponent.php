<?php

if(!defined("BW_APPLICATION"))
{
  die("Direct access to this internal component is forbidden.");
}

//require_once('inc/bwComponent.i18n.php');

define('BW_MESSAGE', 0);
define('BW_WARNING', -1);
define('BW_ERROR', -2);

class bwComponent {

  var $feedback = array();
  
  
/*****************************/
/* Constructor               */
/*****************************/

  function bwComponent()
  {
    //dummy
  }
  
  
/*****************************/
/* i18n                      */
/*****************************/

  function i18n($id)
  {
    global $i18n;
    global $applicaton;
    
    $lang = $application->GetLanguage();
    
    if(isset($i18n[$lang][$id]))
    {
      return $i18n[$lang][$id];
    }
    elseif(isset($i18n[DEFAULT_LANGUAGE][$id]))
    {
      return $i18n[DEFAULT_LANGUAGE][$id];
    }
    else
    {
      return $i18n[$lang]['UNDEFINED'] . ' : ' . $id;
    }
  }
  
/*****************************/
/* Feedback set/get          */
/*****************************/

  function SetFeedback($id, $errorLevel = BW_MESSAGE, $itemId = false)
  {
    
    $this->feedback[] = array('level' => $errorLevel, 'id' => $id, 'itemId' => $itemId);
  }
  
  function GetFeedbackHTML()
  {
    $html = "<" . HTML_COMPONENT_FEEDBACK . " class=\"" . CSS_COMPONENT_FEEDBACK . "\" >\n";
    foreach($this->feedback as $feedback)
    {
      switch($errorLevel)
      {
        case BW_ERROR:
          $class = CSS_COMPONENT_ERROR;
        break;
        case BW_WARNING:
          $class = CSS_COMPONENT_WARNING;
        break;
        case BW_MESSAGE:
        default:
          $class = CSS_COMPONENT_MESSAGE;
      }
      $message = $this->i18n($feedback['id']);
    
      $html .= "<" . HTML_COMPONENT_FEEDBACK_ITEM .  " class=\"$class\">" . $message . "</" . HTML_COMPONENT_FEEDBACK_ITEM . ">\n";
    }
    $html .= "</" . HTML_COMPONENT_FEEDBACK . ">\n";
  }
  
}

?>
