<?php

if(!defined("BW_APPLICATION"))
{
  die("Direct access to this internal component is forbidden.");
}

//require_once('inc/bwDataset.i18n.php');

class bwDataset extends bwComponent {

  var $TABLE;
  var $PRIMARY_KEY;
  var $FIELDS = array();
  var $SORT_FIELD;
  var $sort_reversed;
  var $FILTER;

  //var $id;
  //var $page;

  //var $limit;

  var $item = array();
  
  //var $saved;  
  
/*****************************/
/* Constructor               */
/*****************************/

  function bwDataset()
  {
    $this->SetTable('Example');
    $this->SetFields('id, value');
    $this->SetPrimaryKey('id');
  
    $this->SORT_FIELD = 'id';
    $this->sort_reversed = false;
    $this->FILTER = false;
    
    $this->feedback = '';
    $this->error = false;
  }
  
/*****************************/
/* Field Set/Get functions   */
/*****************************/

  function SetTable($table)
  {
    $this->TABLE = $table;
  }
  
  function GetTableName()
  {
    return $this->TABLE;
  }
  
  
  function SetFields($fields)
  {
    if(!is_array($fields))
    {
      $fields = explode(',', $fields);
    }
    
    foreach($fields as $field)
    {
      $this->FIELDS[] = trim($field);
    }
  }

  function GetFields()
  {
    return $this->FIELDS;
  }
  

  function SetPrimaryKey($key)
  {
    $this->PRIMARY_KEY = $key;
  }

  function GetPrimaryKey($key)
  {
    return $this->PRIMARY_KEY;
  }


  function SetSort($field, $reversed = false)
  {
    $this->SORT_FIELD = $field;
    $this->sort_reversed = ($reversed == true);
  }

  function GetSort()
  {
    return $this->SORT_FIELD;
  }

  function IsSortReversed()
  {
    return $this->sort_reversed;
  }


/*****************************/
/* Select one item           */
/*****************************/
  
  function Select($key)
  {
    global $database;
  
    $where = $this->GenerateKey($key);
    
    $sql = "SELECT * FROM " . $this->TABLE . " " . $where . "LIMIT 1 ";
    
    if($database->Query($sql))
    {
      $this->item = $database->FetchRow();
      //$this->error = false;
    }
    else
    {
      $this->SetFeedback(DB_ERROR, BW_ERROR);
      //$this->error = true;
    }
  }


/*****************************/
/* Internal select functions */
/*****************************/

  function SelectAllWhere($where_sql = '')
  {
    $fields_sql = "*";
    $tables_sql = $this->TABLE;
    $sort_sql = $this->GenerateSort();
    
    return $this->_selectMany($fields_sql, $tables_sql, $where_sql, $sort_sql);
  
  }

  
  function _select1($fields_sql, $tables_sql, $where_sql)
  {
    global $database;
  
    $sql = "SELECT $fields_sql FROM $tables_sql WHERE $where_sql LIMIT 1 ";
    
    if($database->Query($sql))
    {
      $this->item = array();
			if($row = $database->FetchRow())
			{
	      $this->item[] = $row;
				return 1;
			}
			else
			{
				return 0;
			}
    }
    else
    {
      $this->SetFeedback(DB_ERROR, BW_ERROR);
			$this->Clear();
			return -1;
    }
  }

  function _selectMany($fields_sql, $tables_sql, $where_sql = '', $sort_sql = '', $limit_sql = '')
  {
    global $database;
  
    $sql = "SELECT $fields_sql FROM $tables_sql ";
    
    $sql .= ($where_sql == '') ? "" : "WHERE $where_sql ";
    $sql .= ($sort_sql == '') ? "" : "$sort_sql ";
    $sql .= ($limit_sql == '') ? "" : "LIMIT $limit_sql ";
    
		echo "<pre>$sql</pre>";
		
    if($database->Query($sql))
    {
      $this->item = array();

      while($row = $database->FetchRow()) 
      {
        $this->item[] = $row;
      }
      
			return sizeof($this->item);
    }
    else
    {
      $this->SetFeedback(DB_ERROR, BW_ERROR);
			return -1;
    }
  }


/*****************************/
/* Select all items          */
/*****************************/
  
  function SelectAll()
  {
    global $database;

    $sql = "SELECT * FROM " . $this->TABLE . " " . $this->GenerateSort();
    
    if($database->Query($sql))
    {
      $this->item = array();
      
      while($row = $database->FetchRow()) 
      {
        $this->item[] = $row;
      }
      
      //$this->error = false;
    }
    else
    {
      $this->SetFeedback(DB_ERROR, BW_ERROR);
      //$this->error = true;
    }
  
  }

/*****************************/
/* Select one page of items  */
/*****************************/
  
  function SelectPage($page)
  {
    global $database;

    $sql = "SELECT * FROM " . $this->TABLE . " ";
    
    if($database->Query($sql))
    {
      $this->item = array();
      
      while($row = $database->FetchRow()) 
      {
        $this->item[] = $row;
      }
      
      //$this->error = false;
    }
    else
    {
      $this->SetFeedback(DB_ERROR, BW_ERROR);
      //$this->error = true;
    }
  
  }

/*****************************/
/* Insert new item           */
/*****************************/

  function Insert($values)
  {
    global $database;
    
    $fieldList = implode(', ', $this->FIELDS);
    $valuesSorted = array();
    foreach($this->FIELDS as $field)
    {
      $valuesSorted[] = isset($values[$field]) ? "'$values[$field]'" : "''";
    }
    $valueList = implode(', ', $valuesSorted);
    
    $sql = "INSERT INTO " . $this->TABLE . " ( " . $fieldList . " ) VALUES ( " . $valueList . " ) ";
	
    if($database->Query($sql))
    {
      //$this->error = false;
    }
    else
    {
      $this->SetFeedback(DB_ERROR, BW_ERROR);
      //$this->error = true;
    }

  }

/*****************************/
/* Update item               */
/*****************************/

// usage: Update($fuId, array("foo" => "bar", "fu" => $bar));

  function Update($key, $values)
  {
    global $database;
    
    $where = $this->GenerateKey($key);

    $set = array();

    foreach($values as $field => $value)
    {
      if(isset($this->FIELDS[$field]))
      {
        $set[] = $field . " = '" . $value . "'";
      }
    }
    
    $setList = implode(', ', $set);
    
    $sql = "UPDATE " . $this->TABLE . " SET " . $setList . " " . $where . " LIMIT 1 ";
    
    if($database->Query($sql))
    {
      //$this->error = false;
    }
    else
    {
      $this->SetFeedback(DB_ERROR, BW_ERROR);
      //$this->error = true;
    }
         
  }

/*****************************/
/* Delete item               */
/*****************************/

  function Delete($key)
  {
    global $database;
    
    $where = $this->GenerateKey($key);
    
    $sql = "DELETE FROM " . $this->TABLE . " " . $where . "LIMIT 1 ";
    
    if($database->Query($sql))
    {
      $this->item = $database->FetchRow();
      //$this->error = false;
    }
    else
    {
      $this->SetFeedback(DB_ERROR, BW_ERROR);
      //$this->error = true;
    }
  }

/*****************************/
/* Internal functions        */
/*****************************/
  
  function GenerateKey($key)
  {
    if(is_array($key))
    {
      $sql = '';
      $separator = "WHERE ";
      foreach($key as $field => $value)
      {
        if(is_array($value))
        {
        
        }
        else
        {
        
        }
      }  
    }
    else
    {
      $sql = "WHERE " . $this->PRIMARY_KEY . "='" . $key . "' ";
    }
    
    return $sql;
  }
  
  
  function GenerateSort($field = false, $sortdir = false)
  {
    if($sortdir === false)
    {
      $dir = ($this->sort_reversed) ? 'DESC' : 'ASC';
    }
    else
    {
      $dir = ($this->sortdir === -1) ? 'DESC' : 'ASC';
    }
  
    $sql = 'ORDER BY '
         . (($field == false) ? $this->SORT_FIELD : $field) . ' '
         . $dir . ' ';
         
    return $sql;
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

?>
