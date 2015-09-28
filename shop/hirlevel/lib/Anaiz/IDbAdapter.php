<?php

interface IDbAdapter {
    public function connect($to);
    public function isConnected();
    public function getDbType();
    public function executeQuery($query);
    public function fetchRecord($resource);
    public function escape($value);
    public function unescape($value);
    public function columnToAttribute($columnName);
    public function attributeToColumn($attributeId);
}

