<?php

class DbAdapter_MySql implements IDbAdapter {

    const TYPE = 'MySql';

    protected $link = null;

    public function connect($to) {
        $this->link = mysql_connect($to['server'], $to['username'], $to['password']);
        if ($this->link && mysql_select_db($to['database'], $this->link)) {
            //mysql_set_charset('utf8', $this->link);
            mysql_query("set character set utf8", $this->link);
            //mysql_query("set names utf8", $this->link);
            return true;
        } else {
            $this->link = null;
            return false;
        }
    }

    public function isConnected() {
        return (null !== $this->link);
    }

    public function getDbType() {
       return self::TYPE;
    }

    public function executeQuery($query) {
        //echo "<pre>" . $query . "</pre>\n";
        return mysql_query($query, $this->link);
    }

    public function fetchRecord($resource) {
        return mysql_fetch_assoc($resource);
    }

    public function escape($value) {
        return mysql_escape_string($value);
    }
    
    public function unescape($value) {
        return stripslashes($value);
    }

    public function getLastInsertId() {
        return mysql_insert_id($this->link);
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
