<?php

class bwDatabase {
  
  var $connection;
  var $resource;
  var $row;
  
  var $feedback;
  var $saved;
  
  function bwDatabase($server = '', $user = '', $password = '', $db = '')
  {
    $server = ($server == '') ? BW_DB_SERVER : $server;
    $user = ($user == '') ? BW_DB_USER : $user;
    $password = ($password == '') ? BW_DB_PASSWORD : $password;
    $db = ($db == '') ? BW_DB_DATABASE : $db;
  
    $this->feedback = '';
    $this->saved = false;
  
    $this->connection = mysql_connect($server, $user, $password)
      or die("Cannot connect to Database.");

    mysql_query("set character set latin2");
    mysql_query("set names latin2");
    mysql_select_db($db, $this->connection);
    
    $this->resoruce = false;


  }
  
  function Query($query)
  {
    if(is_resource($this->resource))
    {
      //mysql_free_resource($this->resource);
    }
		
    if(BW_DEBUG_SQLDUMP) echo "<pre>SQL&gt; $query</pre>";
  
    return ($this->resource = mysql_query($query, $this->connection)) ? true : false;
  }
  
  function GetInsertId()
  {
  	// DOES NOT WORK ON BIGINT KEYS, ONLY LONG!!!
  	//return mysql_insert_id($this->connection);
  	return mysql_insert_id();
  }
  
  function GetResource()
  {
    return $this->resource;
  }
  
  function FetchRow()
  {
    return ($this->row = mysql_fetch_array($this->resource)) ? $this->row : false;
  }
  
  function GetRow()
  {
    return $this->row;
  }
  
  function HasField($name)
  {
    return isset($this->row[$name]);
  }
  
  function GetField($name)
  {
    return $this->row[$name];
  }

  function GetRandomString($minLength = 8, $maxLength = 12)
  {
    $a = 'aeiou';
    $b = 'bcdfghjklmnpqrstvwxyz';
    
    $amax = strlen($a) - 1;
    $bmax = strlen($b) - 1;

    $length = rand($minLength, $maxLength);
  
    $rr = rand(0, $amax + $bmax + 1);
    if($rr<=$amax)
    {
      $word = $a{rand(0, $amax)};
      $last = 'a';
    }
    else
    {
      $word = $b{rand(0, $bmax)};
      $last = 'b';
    }
      
    for($i=1; $i<=$length; $i++)
    {
      if($last=='a')
      {
        if(rand(1,100) <= 10)
        {
          $word .= $a{rand(0, $amax)};
          $last = 'aa';
        }
        else
        {
          $word .= $b{rand(0, $bmax)};
          $last = 'b';
        }
      }
      elseif($last=='aa')
      {
        $word .= $b{rand(0, $bmax)};
        $last = 'b';
      }
      elseif($last=='b')
      {
        if(rand(1,100) <= 65)
        {
          $word .= $a{rand(0, $amax)};
          $last = 'a';
        }
        else
        {
          $word .= $b{rand(0, $bmax)};
          $last = 'bb';
        }
      }
      elseif($last=='bb')
      {
        if(rand(1,100) <= 95)
        {
          $word .= $a{rand(0, $amax)};
          $last = 'a';
        }
        else
        {
          $word .= $b{rand(0, $bmax)};
          $last = 'bbb';
        }
      }
      else
      {
        $word .= $a{rand(0, $amax)};
        $last = 'a';
      }
    }
    
    $return = '';
    
    for($i=0; $i<$length; $i++)
    {
      $return .= (rand(1,7) == 1) ? strtoupper($word{$i}) : $word{$i};
    }
    
    return $return;
  }

  function UserExists($field, $value)
  {
    $value = trim($value);
  
    $sql = "SELECT * FROM " . TBL_USER 
         . " WHERE " . $field .  "='" . $value . "'"
         . " LIMIT 1";
  
    return ($this->Query($sql) && $this->FetchRow()) ? $this->row['active'] : false;
  }


  function UserEmailExists($email)
  {
    return $this->UserExists('email', $email);
  }

  function UserIdExists($id)
  {
    return $this->UserExists('id', $id);
  }

  function UserNameExists($name)
  {
    return $this->UserExists('nick', $name);
  }

  function Login($email, $password)
  {
    $this->feedback = '';
  
    if($this->UserEmailExists($email) && $this->row['password'] == md5($password))
    {
      $sql = 'UPDATE ' . TBL_USER
           . ' SET last_login = \'' . $this->row['last_login_2'] . '\', '
           . ' last_login_2 = \'' . date('Y-m-d H:i:s') . '\' '
           . ' WHERE id = ' . $this->row['id']
           . ' LIMIT 1';

      $this->Query($sql);
      
      $this->saved = true;
      
      return true;
    }
    
    $this->feedback .= 'Emailcím vagy jelszó nem megfelelõ!<br />';
    $this->saved = false;
    return false;
  }
  
  function Logout()
  {
    return true;
  }

}

$database = new bwDatabase;

?>
