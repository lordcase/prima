<?php

class Navigation extends Resource {

    public function setLabel($label) {
        return $this->writeAttributeValue('label', $label);
    }

    public function getLabel() {
        return $this->readAttributeValue('label');
    }

    public function setWeight($weight) {
        return $this->writeAttributeValue('weight', $weight);
    }

    public function getWeight() {
        return $this->readAttributeValue('weight');
    }

    public function setExternalUrl($externalUrl) {
        return $this->writeAttributeValue('external_url', $externalUrl);
    }

    public function getExternalUrl() {
        return $this->readAttributeValue('external_url', '');
    }
    
    public function setController($controller) {
        return $this->writeAttributeValue('controller', $controller);
    }
    
    public function getController() {
        return $this->readAttributeValue('controller');
    }
    
    public function setAction($action) {
        return $this->writeAttributeValue('action', $action);
    }
    
    public function getAction() {
        return $this->readAttributeValue('action');
    }

    public function isExternal() {
        return ('' != $this->getExternalUrl());
    }
    
    public function getHref() {
        if ($this->isExternal()) {
            return $this->getExternalUrl();
        } else {
            $params = null;
            return Request::link($this->getController(), $this->getAction(), $params);
        }
    }

    public function setGroupId($groupId) {
        return $this->writeAttributeValue('group_id', $groupId);
    }
    
    public function getGroupId() {
        return $this->readAttributeValue('group_id');
    }

}

