<?php

class Identity extends Resource {

    protected $identity;

    public function getFullName() {
        return $this->readAttributeValue('full_name');
    }

    public function setFullName($fullName) {
        return $this->writeAttributeValue('full_name', $fullName);
    }

    public function getEmail() {
        return $this->readAttributeValue('email');
    }

    public function setEmail($email) {
        return $this->writeAttributeValue('email', $email);
    }

    public function getPassword() {
        return $this->readAttributeValue('password');
    }

    public function setPassword($password) {
        return $this->writeAttributeValue('password', $password);
    }

    public function setRawPassword($rawPassword) {
        return $this->setPassword(sha1($rawPassword));
    }

}

