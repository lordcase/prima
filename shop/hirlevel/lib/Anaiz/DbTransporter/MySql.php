<?php

abstract class DbTransporter_MySql extends DbTransporter {

    protected $table = null;

    public function getDbType() {
        return DbAdapter_MySql::TYPE;
    }

    protected function getTableName() {
        return $this->table;
    }

}
