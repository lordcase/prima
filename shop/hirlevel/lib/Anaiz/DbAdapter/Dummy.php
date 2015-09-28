<?php

require_once ANAIZ_MODEL_PATH . 'IDbAdapter.php';

class DbAdapter_Dummy implements IDbAdapter {

    const TYPE = 'Dummy';

    public function connect($to = null) {
        return true;
    }

    public function isConnected() {
        return true;
    }

    public function getDbType() {
       return self::TYPE;
    }

    public function executeQuery($query) {
        throw new Exception('DbAdapter_Dummy cannot execute querries.');
    }

    public function fetchRecord($resource) {
        throw new Exception('DbAdapter_Dummy cannot fetch record.');
    }

    public function escape($value) {
        return $value;
    }

    public function columnToAttribute($columnName) {
        throw new Exception('DbAdapter_Dummy does not have column names.');
    }

    public function  attributeToColumn($attributeId) {
        throw new Exception('DbAdapter_Dummy does not have column names.');
    }

}
