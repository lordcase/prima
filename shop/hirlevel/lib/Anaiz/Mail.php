<?php

class Mail extends Content {
    
    const DRAFT     = 0;
    const OUTBOX    = 1;
    const SENT      = 2;
    const TRASH     = 3;

    public function setSubject($subject) {
        return $this->writeAttributeValue('subject', $subject);
    }
    
    public function getSubject() {
        return $this->readAttributeValue('subject');
    }
    
    public function setBody($body) {
        return $this->writeAttributeValue('body', $body);
    }
    
    public function getBody() {
        return $this->readAttributeValue('body');
    }
    
    public function setStatus($status) {
        return $this->writeAttributeValue('status', $status);
    }
    
    public function getStatus() {
        return $this->readAttributeValue('status');
    }
    
    public function setTheme($theme) {
        return $this->writeAttributeValue('theme', $theme);
    }
    
    public function getTheme() {
        return $this->readAttributeValue('theme');
    }
    
}


