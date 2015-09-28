<?php

class Setting extends Resource {

    protected $autoId = false;

    public function setValue($value) {
        return $this->writeAttributeValue('current_value', $value);
    }
    
    public function getValue() {
        return $this->readAttributeValue('current_value');
    }

    public function setAllowedValue($values) {
        if (!is_array($values)) {
            $values = array($values);
        }
        $values = implode('||', $values);
        return $this->writeAttributeValue('allowed_values', $value);
    }
    
    public function getAllowedValues() {
        $values = $this->readAttributeValue('allowed_values');
        if ($values) {
            $values = explode('||', $values);
        }
        return $values;
    }
    
    /*
    public function setLabel($label) {
        return $this->writeAttributeValue('label', $label);
    }

    public function getLabel() {
        return $this->readAttributeValue('label');
    }*/

    
}

