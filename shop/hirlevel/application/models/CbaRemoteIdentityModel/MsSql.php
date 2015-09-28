<?php

class CbaRemoteIdentityModel_MsSql extends DbTransporter_MsSql {
    
    protected $table = 'dbo.UGYFELEK';
    
    protected function querySelect(CbaRemoteIdentityModel $model, $options = null) {
        $adapter = $this->getDbAdapter();

        $what = '*';
        
        if ($model->getId()) {
            $where = 'ID = \'' . $adapter->escape($model->getId()) . '\'';
        } elseif ($model->getEmail()) {
            $where = 'EMAIL = \'' . $adapter->escape($model->getEmail()) . '\'';
        }  else {
            $where = 'EMAIL <> \'\'';
        }

        $records = array();

        $query = 'SELECT ' . $what . ' FROM ' . $this->getTableName() . ' WHERE ' . $where;
        
        $result = $adapter->executeQuery($query);

        if ($result) {
            while ($record = $adapter->fetchRecord($result)) {
                $email = utf8_encode($record['EMAIL']);
                if (preg_match( "/^[\d\w\/+!=#|$?%{^&}*`'~-][\d\w\/\.+!=#|$?%{^&}*`'~-]*@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i", $email)) {
                    $records[] = array(
                        'id'            => $record['ID'],
                        'full_name'     => utf8_encode($record['NEV']),
                        'email'         => $email,
                    );
                }
            }
        }
        return $records;

    }
    
    public function install() {
        throw new Exception('Uninstall failed.');
    }
    
    public function uninstall() {
        throw new Exception('Uninstall failed.');
    }
}

