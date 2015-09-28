<?php

if(!defined("BW_APPLICATION"))
{
  die("Direct access to this internal component is forbidden.");
}

//require_once('inc/common/bwComponent.i18n.php');

define('BW_MESSAGE', 0);
define('BW_WARNING', -1);
define('BW_ERROR', -2);

class bwComponent {

  var $feedback = array();
  var $view;
  
  
/*****************************/
/* Constructor               */
/*****************************/

  function bwComponent()
  {
    //dummy
  }
  
/*****************************/
/* Set/Get                   */
/*****************************/

  function SetFeedback($id, $errorLevel = BW_MESSAGE, $values = false)
  {
    
    $this->feedback[] = array('level' => $errorLevel, 'id' => $id, 'values' => $values);
  }
  
  function GetFeedback()
  {
    return $this->feedback;
  }

  function SetView($view)
  {
    $this->view = $view;
  }

  function GetView()
  {
    return $this->view;
  }

  function CountFeedback()
  {
    return count($this->feedback);
  }

  
/*****************************/
/* i18n                      */
/*****************************/

  function i18n($id)
  {
    global $i18n;
    global $applicaton;
    
    //$lang = $application->GetLanguage();
    $lang = 'hu';
    
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
/* View functions            */
/*****************************/

  function PrintView()
  {
    $output  = $this->PrintViewHeader();
    $output .= $this->PrintViewBody();
    $output .= $this->PrintViewFooter();
    
    return $output;
  }
  
  function PrintViewHeader()
  {
    return $this->view->PrintHeader();
  }

  function PrintViewBody()
  {
    return '';
  }

  function PrintViewFooter()
  {
    return $this->view->PrintFooter();
  }

  
/*****************************/
/* Print                     */
/*****************************/

  function PrintFeedback()
  {
    $feedbackList = $this->GetFeedback();
  
    $html = "<" . HTML_COMPONENT_FEEDBACK . " class=\"" . CSS_COMPONENT_FEEDBACK . "\" >\n";
    foreach($feedbackList as $feedback)
    {
      switch($feedback['level'])
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
      
      if(is_array($feedback['values']))
      {
        foreach($feedback['values'] as $label => $value)
        {
          $message = str_replace('%' . $label . '%', $value, $message);
        }
      }
    
      $html .= "<" . HTML_COMPONENT_FEEDBACK_ITEM .  " class=\"$class\">" . $message . "</" . HTML_COMPONENT_FEEDBACK_ITEM . ">\n";
    }
    $html .= "</" . HTML_COMPONENT_FEEDBACK . ">\n";
    
    return $html;
  }
  
}

?>
