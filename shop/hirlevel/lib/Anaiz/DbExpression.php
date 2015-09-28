<?php

abstract class DbExpression {
    
    protected $value = null;
    protected $expression = '=';
    
    public function __construct($value) {
        $this->setValue($value);
    }
    
    public function setValue($value) {
        $this->value = $value;
        return $this;
    }
    
    public function getValue() {
        return $this->value;
    }
    
    public function getExpression() {
        return $this->expression;
    }
    
}


