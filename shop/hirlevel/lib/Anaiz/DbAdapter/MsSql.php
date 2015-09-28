<?php

class DbAdapter_MsSql implements IDbAdapter {

    const TYPE = 'MsSql';

    protected $link = null;
    protected $status = 0; // 0 = not tested; 1 = connected; -1 = connection error
    protected $to = array();
    
    protected function estabilishConnection() {
        $this->link = mssql_connect($this->to['server'], $this->to['username'], $this->to['password']);
        if ($this->link && mssql_select_db($this->to['database'], $this->link)) {
            //mssql_query("set character set utf8", $this->link);
            $this->status = 1;
            return true;
        } else {
            $this->link = null;
            $this->status = -1;
            return false;
        }
        
    }

    public function connect($to) {
        $this->link = null;
        $this->status = 0;
        $this->to = $to;
        return $this;
    }

    public function isConnected() {
        if (0 === $this->status) {
            $this->estabilishConnection();
        }
        return (1 == $this->status);
    }

    public function getDbType() {
       return self::TYPE;
    }

    public function executeQuery($query) {
        if (0 === $this->status) {
            $this->estabilishConnection();
        }
        if (1 === $this->status) {
            //echo "<pre>$query</pre>\n";
            return mssql_query($query, $this->link);
        }
    }

    public function fetchRecord($resource) {
        return mssql_fetch_assoc($resource);
    }

    public function escape($value) {
        return str_replace('\'', '\'\'', $value);
    }

    public function unescape($value) {
        return str_replace('\'\'', '\'', $value);
    }

    public function getLastInsertId() {
        // TODO: implement this!
        $query = 'SELECT IDENT_CURRENT(' . $tableName . ')';
        return null;
        //return mysql_insert_id($this->link);
    }

    public function columnToAttribute($columnName) {
        $parts = explode('_', $columnName);
        $attributeId = '';
        foreach ($parts as $part) {
            $attributeId .= ucfirst($part);
        }
        return $attributeId;
    }

    public function  attributeToColumn($attributeId) {
        return strtolower(preg_replace('/([a-z0-9])([A-Z])/', "$1$_$2", $attributeId));
    }


}
