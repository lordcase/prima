<?php

class Resource_MySql extends DbTransporter_MySql {

    protected $table = 'resource';

    /*
    protected function querySelect(IResource $model) {
        $adapter = $this->getDbAdapter();

        $where = $model->getAttributes();
        if (is_array($where) && count($where)) {
            $whereParts = array();
            foreach ($where as $column => $value) {
                $whereParts[] = $column . ' = \'' . $adapter->escape($value) . '\'';
            }
            $queryPartWhere = ' WHERE ' . implode(' AND ', $whereParts);
        } else {
            $queryPartWhere = '';
        }

        $query = 'SELECT * FROM ' . $this->getTableName() . $queryPartWhere . ' LIMIT 1';

        $result = $adapter->executeQuery($query);
        if ($result) {
            $record = $adapter->fetchRecord($result);
            return $record;
        }
        return array();
    }
     */

    protected function querySelect(IResource $model, $options = null) {
        $adapter = $this->getDbAdapter();

        $where = $model->getAttributes();
        if (is_array($where) && count($where)) {
            $whereParts = array();
            foreach ($where as $column => $value) {
                if (is_a($value, 'DbExpression')) {
                    $operator = $value->getExpression();
                    $value = $value->getValue();
                } else {
                    $operator = '=';
                }
                
                if (is_a($value, 'DbFunction')) {
                    $value = $value->getFunction();
                } else {
                    $value = '\'' . $adapter->escape($value) . '\'';
                }
                
                $whereParts[] = $column . ' ' . $operator . ' ' . $value;
            }
            $queryPartWhere = ' WHERE ' . implode(' AND ', $whereParts);
        } else {
            $queryPartWhere = '';
        }
        
        if (null === $options) {
            $options = $model->getQueryOptions();
        }

        if (is_array($options)) {
            $what       = isset($options['what']) ? $options['what'] : '*';
            $orderBy    = isset($options['order_by']) ? $options['order_by'] : null;
            $limit      = isset($options['limit']) ? $options['limit'] : null;
            $offset     = isset($options['offset']) ? $options['offset'] : null;

            if (is_array($orderBy)) {
                $queryPartOrderBy = ' ORDER BY ' . implode(', ', $orderBy);
            } elseif (null != $orderBy) {
                $queryPartOrderBy = ' ORDER BY ' . $orderBy;
            } else {
                $queryPartOrderBy = '';
            }

            if (null !== $limit) {
                $queryPartLimit = ' LIMIT ' . $limit . ((null !== $offset) ? (' OFFSET ' . $offset) : '');
            } else {
                $queryPartLimit = '';
            }

            $queryParts = $queryPartWhere . $queryPartOrderBy . $queryPartLimit;
        } else {
            $what = '*';
            $queryParts = $queryPartWhere . ((null === $options) ? '' : (' ' . $options));
        }

        $records = array();

        $query = 'SELECT ' . $what . ' FROM ' . $this->getTableName() . $queryParts;
        $result = $adapter->executeQuery($query);

        if ($result) {
            while ($record = $adapter->fetchRecord($result)) {
                $records[] = $record;
            }
        }
        return $records;

    }
    
    protected function queryCount(IResource $model, $options = null) {
        if (null === $options) {
            $options = $model->getQueryOptions();
        }
        
        if (!is_array($opions)) {
            $options = array();
        }
        
        $options['what'] = 'COUNT(*) AS counter';
        $records = $this->querySelect($model, $options);
        if (is_array($records) && !empty($records)) {
            $count = $records[0]['counter'];
        } else {
            $count = 0;
        }
        return $count;
    }
    
    protected function queryMultiSelect(IResource $model, $options = null) {
        return $this->querySelect($model, $options);
    }

    protected function queryInsert(IResource $model) {

        $adapter = $this->getDbAdapter();

        $queryParts = array('columns' => array(), 'values' => array());
        foreach ($model->getAttributes() as $key => $value) {
            $queryParts['columns'][] = $key;
            $queryParts['values'][] = '\'' . $adapter->escape($value) . '\'';
        }

        $query = 'INSERT INTO ' . $this->getTableName() . ' (' . implode(', ', $queryParts['columns']) . ') VALUES(' . implode(', ', $queryParts['values']) . ')';
        $result = $adapter->executeQuery($query);
        if ($result) {
            $model->setId($adapter->getLastInsertId());
        }
        return $result;
    }

    protected function queryUpdate(IResource $model) {

        $adapter = $this->getDbAdapter();

        $queryParts = array();
        foreach($model->getAttributes() as $key => $value) {
            if ('id' !== $key) {
                $queryParts[] = $key . ' = \'' . $adapter->escape($value) . '\'';
            }
        }

        $query = 'UPDATE ' . $this->getTableName() . ' SET ' . implode(', ', $queryParts) . ' WHERE id = ' . $model->getId() . ' ';
        return $adapter->executeQuery($query);
    }

    protected function queryDelete(IResource $model) {
        $query = 'DELETE FROM ' . $this->getTableName() . ' WHERE id = ' . $model->getId() . ' LIMIT 1 ';
        return $this->getDbAdapter()->executeQuery($query);
    }
    
    public function install() {
        $query = "CREATE TABLE `" . $this->getTableName() . "` ("
               . "`id` bigint(20) unsigned NOT NULL auto_increment, "
               . "`resource_type` varchar(120) NOT NULL default '', "
               . " `deleted` tinyint(4) NOT NULL default '0', "
               . " PRIMARY KEY  (`id`) "
               . ") TYPE=MyISAM ; ";
        return $this->getDbAdapter()->executeQuery($query);
    }
    
    public function uninstall() {
        throw new Exception('Uninstall failed.');
    }
}

