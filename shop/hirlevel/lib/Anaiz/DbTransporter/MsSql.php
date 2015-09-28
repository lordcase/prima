<?php

abstract class DbTransporter_MsSql extends DbTransporter {

    protected $table = null;

    public function getDbType() {
        return DbAdapter_MsSql::TYPE;
    }

    protected function getTableName() {
        return $this->table;
    }

}
