<?php

abstract class DbTransporter implements IDbTransporter {

    protected $adapter = null;

    public function setDbAdapter(IDbAdapter $dbAdapter) {
        if ($this->getDbType() == $dbAdapter->getDbType()) {
            $this->adapter = $dbAdapter;
        } else {
            throw new Exception('setDbAdapter() failed: DbAdapter type does not match DbTransporter type.');
        }
    }

    public function getDbType() {
        throw new Exception('getDbType() failed: abstract method needs to be overridden in subclass.');
    }

    public function query($queryId, $object = null, $options = null) {
        $methodName = 'query' . $queryId;
        if (method_exists($this, $methodName)) {
            return (null === $options) ? $this->$methodName($object) : $this->$methodName($object, $options);
        } else {
            throw new Exception('Cannot execute query. Correspondig method not found on DbTransporter');
        }
    }

    protected function getDbAdapter() {
        if (null == $this->adapter) {
            throw new Exception('getDbAdapter() failed: ao DbAdpater found on DbTransporter.');
        }
        return $this->adapter;
    }

}

