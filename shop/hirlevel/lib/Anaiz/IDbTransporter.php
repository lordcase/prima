<?php

interface IDbTransporter {
    public function setDbAdapter(IDbAdapter $dbAdapter);
    public function getDbType();
    public function query($queryId, $object = null);
    public function install();
    public function uninstall();
}

