<?php

class CbaIdentityModel extends Identity {

    public function setLevel($level) {
        return $this->writeAttributeValue('level', $level);
    }
    
    public function getLevel() {
        return $this->readAttributeValue('level');
    }
    
    public function setFullName($fullName) {
        return $this->writeAttributeValue('nick', $fullName);
    }
    
    public function getFullName() {
        return $this->readAttributeValue('nick');
    }
    
    public function setRawPassword($rawPassword) {
        return $this->setPassword(md5($rawPassword));
    }
    
    public function getSubscription() {
        return $this->readAttributeValue('subscription');
    }
    
    public function setSubscription($subscription) {
        return $this->writeAttributeValue('subscription', $subscription);
    }
}


