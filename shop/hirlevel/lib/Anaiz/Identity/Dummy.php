<?php

require_once ANAIZ_MODEL_PATH . 'DbTransporter/Dummy.php';
require_once ANAIZ_MODEL_PATH . 'Identity.php';

class Identity_Dummy extends DbTransporter_Dummy {

    protected $data = array(
        array('id' => 1, 'email' => 'info@anaiz.hu', 'password' => '123456'),
    );

    public function querySelect(Identity $model) {
        
    }

}

