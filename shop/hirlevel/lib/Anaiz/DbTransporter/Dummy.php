<?php

require_once ANAIZ_MODEL_PATH . 'DbTransporter.php';

abstract class DbTransporter_Dummy extends DbTransporter {

    public function getDbType() {
        require_once ANAIZ_MODEL_PATH . 'DbAdapter/Dummy.php';
        return DbAdapter_Dummy::TYPE;
    }

}
