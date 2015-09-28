<?php

abstract class Content extends Resource implements IContent {
    
    /*public function  __construct(IDbAdapter $dbAdapter, $id = null) {
        $this->setDbAdapter($dbAdapter);
    }*/

    public function save() {
        if ($this->isWritable()) {
            if ($this->isModified()) {
                $transporter = $this->getDbTransporter();

                $timestamp = date('Y-m-d H:i:s');
                $identity = null; // TODO: Get the identity

                $this->items[$this->pointer]['modification_timestamp'] = $timestamp;
                $this->items[$this->pointer]['modification_identity'] = $identity;

                if (null === $this->getId()) {
                    if ($this->autoId) {
                        $this->items[$this->pointer]['creation_timestamp'] = $timestamp;
                        $this->items[$this->pointer]['creation_identity'] = $identity;

                        if (!isset($this->items[$this->pointer]['publication_timestamp'])) $this->items[$this->pointer]['publication_timestamp'] = $timestamp;
                        if (!isset($this->items[$this->pointer]['publication_identity'])) $this->items[$this->pointer]['publication_identity'] = $identity;

                        $result = $transporter->query('Insert', $this);
                    } else {
                        throw new Exception('Cannot save Content: Id is missing.');
                    }
                } else {
                    if ($this->autoId || false) {
                        // TODO check if record exists
                        $result = $transporter->query('Update', $this);
                    } else {
                        $this->items[$this->pointer]['creation_timestamp'] = $timestamp;
                        $this->items[$this->pointer]['creation_identity'] = $identity;

                        if (!isset($this->items[$this->pointer]['publication_timestamp'])) $this->items[$this->pointer]['publication_timestamp'] = $timestamp;
                        if (!isset($this->items[$this->pointer]['publication_identity'])) $this->items[$this->pointer]['publication_identity'] = $identity;
                        
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
            throw new Exception('Cannot save Content: access is denied.');
        }
        return $result;
    }

    public function delete() {
        if ($this->isDeletable()) {
            if ((null !== $this->getId()) && !$this->isDeleted()) {
                $transporter = $this->getDbTransporter();

                $this->items[$this->pointer]['deleted'] = 1;

                $timestamp = date('Y-m-d H:i:s');
                $identity = null; // TODO: Get the identity

                if ($this->isModified()) {
                    $this->items[$this->pointer]['modification_timestamp'] = $timestamp;
                    $this->items[$this->pointer]['modification_identity'] = $identity;
                }

                $this->items[$this->pointer]['deletion_timestamp'] = $timestamp;
                $this->items[$this->pointer]['deletion_identity'] = $identity;
                
                $result = $transporter->query('Delete', $this);

            } else {
                $result = true;
            }

        } else {
            throw new Exception('Cannot delete Content: access is denied.');
        }
        return $result;
    }

    public function getCreationTimestamp() {
        return $this->readAttributeValue('creation_timestamp');
    }

    public function setCreationTimestamp($timestamp) {
        return $this->writeAttributeValue('creation_timestamp', $timestamp);
    }

    public function getCreationIdentity() {
        return 0; // TODO: Implement this
    }

    public function getModificationTimestamp() {
        return $this->readAttributeValue('modification_timestamp');
    }

    public function getModificationIdentity() {
        return 0; // TODO: Implement this
    }

    public function setModificationTimestamp($timestamp) {
        return $this->writeAttributeValue('modification_timestamp', $timestamp);
    }

    public function getDeletionTimestamp() {
        return $this->readAttributeValue('deleted') ? $this->readAttributeValue('deletion_timestamp') : null;
    }

    public function getDeletionIdentity() {
        return 0; // TODO: Implement this
    }

    public function getPublicationTimestamp() {
        return $this->readAttributeValue('publication_timestamp');
    }

    public function setPublicationTimestamp($timestamp) {
        return $this->writeAttributeValue('publication_timestamp', $timestamp);
    }

    public function getPublicationIdentity() {
        return 0; // TODO: Implement this
    }

    public function setPublicationIdentity($identity) {
        return true; // TODO: Implement this
    }

    public function getLocale() {
        return $this->readAttributeValue('locale');
    }

    public function setLocale($locale) {
        return $this->writeAttributeValue('locale', $locale);
    }

}

