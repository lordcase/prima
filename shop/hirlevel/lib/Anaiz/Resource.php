<?php

abstract class Resource implements IResource {

    protected $pointer = null;
    protected $items = array();
    //protected $attributes = array();

    protected $modified = array();
    protected $dbAdapter = null;
    protected $dbTransporter = null;
    protected $queryOptions = null;
    
    protected $autoId = true;


    public function getResourceType() {
        return $this->readAttributeValue('resource_type');
    }

    public function setResourceType($resourceType) {
        return $this->writeAttributeValue('resource_type', $resourceType);
    }

    public function prev() {
        if ($this->pointer > 0) {
            $this->pointer -= 1;
            return $this;
        } else {
            return null;
        }
    }

    public function next() {
        if ($this->pointer < (count($this->items) - 1)) {
            $this->pointer += 1;
            return $this;
        } else {
            return null;
        }
    }

    public function first() {
        if (!empty($this->items)) {
            $this->pointer = 0;
            return $this;
        }
    }

    public function last() {
        if (!empty($this->items)) {
            $this->pointer = count($this->items) - 1;
            return $this;
        }
    }
    
    public function isEmptyCollection() {
        return 0 === $this->getCollectionLength();
    }

    public function getCollectionLength() {
        return count($this->items);
    }

    public function isReadable() {
        return true;
    }

    public function isWritable() {
        return $this->pointer !== null;
    }

    public function isDeletable() {
        return $this->pointer !== null;
    }

    public function getAttribute($attribute) {
        $getter = 'get' . $attribute;
        if (('getattribute' != strtolower($getter)) && ('getattributes' != strtolower($getter)) && method_exists($this, $getter)) {
            return $this->$getter();
        } else {
            throw new Exception('Cannot get attribute "' . $attribute . '" on Resource. No getter method found.');
        }
    }

    public function  getAttributes() {
        if ($this->pointer !== null) {
            return $this->items[$this->pointer];
        } else {
            return array();
        }
        
    }

    public function setAttribute($attribute, $value) {
        $setter = 'set' . $attribute;
        if (('setattribute' != strtolower($setter)) && ('setattributes' != strtolower($setter)) && method_exists($this, $setter)) {
            return $this->$setter($value);
        } else {
            throw new Exception('Cannot set attribute "' . $attribute . '" on Resource. No setter method found.');
        }
    }

    public function setAttributes($attributes) {
        if (is_array($attributes) && !empty ($attributes)) {
            foreach ($attributes as $attribute => $value) {
                $this->setAttribute($attribute, $value);
            }
        }
        return $this;
    }

    public function setDbAdapter(IDbAdapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
        return $this;
    }
    
    public function getQueryOptions() {
        return $this->queryOptions;
    }

    public function setQueryOptions($options) {
        $this->queryOptions = $options;
        return $this;
    }

    public function getId() {
        return $this->readAttributeValue('id');
    }

    public function setId($id) {
        return $this->writeAttributeValue('id', $id);
    }

    public function isModified() {
        if (null !== $this->pointer) {
            return (false !== $this->modified[$this->pointer]);
        } else {
            return false;
        }
    }

    public function isDeleted() {
        if (null !== $this->pointer) {
            return isset($this->items[$this->pointer]['deleted']) && $this->items[$this->pointer]['deleted'];
        } else {
            return false;
        }
    }

    public function read() {
        $this->items = $this->getDbTransporter()->query('select', $this);
        $this->modified = array();
        if (!empty($this->items)) {
            foreach ($this->items as $id => $value) {
                $this->modified[$id] = false;
            }
            $this->pointer = 0;
            return true;
        } else {
            $this->pointer = null;
            return false;
        }
    }
    
    public function count() {
        return $this->getDbTransporter()->query('count', $this);
    }

    public function save() {
        if ($this->isWritable()) {
            if ($this->isModified()) {
                $transporter = $this->getDbTransporter();
                if (null === $this->getId()) {
                    if ($this->autoId) {
                        $result = $transporter->query('Insert', $this);
                    } else {
                        throw new Exception('Cannot save Resource: Id is missing.');
                    }
                } else {
                    if ($this->autoId || false) {
                        // TODO check if record exists
                        $result = $transporter->query('Update', $this);
                    } else {
                        $result = $transporter->query('Insert', $this);
                    }
                }
                if ($result) {
                    $this->modified = false;
                }
            } else {
                $result = true;
            }
        } else {
            throw new Exception('Cannot save Resource: access is denied.');
        }
        return $result;
    }

    public function delete() {
        if ($this->isDeletable()) {
            if ((null !== $this->getId()) && !$this->isDeleted()) {
                $transporter = $this->getDbTransporter();
                $this->attributes['deleted'] = 1;
                $result = $transporter->query('Delete', $this);
            } else {
                $result = true;
            }

        } else {
            throw new Exception('Cannot delete Resource: access is denied.');
        }
        return $result;
    }
    
    public function install() {
        $this->getDbTransporter()->install();
        return $this;
    }

    public function uninstall() {
        $this->getDbTransporter()->uninstall();
        return $this;
    }

    protected function getDbTransporter() {
        if (null === $this->dbTransporter) {
            $dbAdapter = $this->getDbAdapter();
            if (null !== $dbAdapter) {
                $transporterClass = get_class($this) . '_' . $dbAdapter->getDbType();
                if (class_exists($transporterClass)) {
                    $this->dbTransporter = new $transporterClass;
                    $this->dbTransporter->setDbAdapter($dbAdapter);
                } else {
                    throw new Exception('Cannot get DbTransporter: file ' . $transporterFile . ' not found.');
                }
            } else {
                throw new Exception('Cannot get DbTransporter: DbAdapter is not set.');
            }
        }
        return $this->dbTransporter;
    }
    
    protected function getDbAdapter() {
        if (null == $this->dbAdapter) {
            if (Registry::exists('db')) {
                $this->dbAdapter = Registry::get('db');
            }
        }
        return $this->dbAdapter;    
    }

    protected function readAttributeValue($attributeId, $defaultValue = NULL) {
        if (null === $this->pointer) {
            $this->items[0] = array();
            $this->modified[0] = false;
            $this->pointer = 0;
        }
        return isset($this->items[$this->pointer][$attributeId]) ? $this->items[$this->pointer][$attributeId] : $defaultValue;
    }

    protected function writeAttributeValue($attributeId, $value) {
        if (null === $this->pointer) {
            $this->items[0] = array();
            $this->modified[0] = false;
            $this->pointer = 0;
        }
        if (!isset($this->items[$this->pointer][$attributeId]) || ($this->items[$this->pointer][$attributeId] !== $value)) {
            $this->items[$this->pointer][$attributeId] = $value;
            $this->modified[$this->pointer] = true;
        }
        return $this;
    }
    
}

