<?php

class CbaSubscriberModel extends Resource {

    public function isDeletable() {
        return false;
    }
    
    public function isWritable() {
        return false;
    }
    
    protected function getDbAdapter() {
        return null;
    }

    protected function getDbTransporter() {
        return null;
    }
    
    public function getFullName() {
        return $this->readAttributeValue('name');
    }
    
    public function getEmail() {
        return $this->readAttributeValue('email');
    }

    public function getLocalStatus() {
        return $this->readAttributeValue('local');
    }

    public function getRemoteStatus() {
        return $this->readAttributeValue('remote');
    }

    public function read() {
        $remoteModel = new CbaRemoteIdentityModel();
        $unsubsriberModel = new CbaUnsubscriberModel();
        $localModel = new CbaIdentityModel();
        
        // Read Remote Users from the Remote Database, and remove Unsubscribers from the Local Model.

        $remoteModel->read();
        $remote = array();
        
        if (!$remoteModel->isEmptyCollection()) {
            
            $unsubscribers = array();
            $unsubsriberModel->read();
            
            if (!$unsubsriberModel->isEmptyCollection()) {
                while ($unsubsriberModel) {
                    $unsubscribers[intval($unsubsriberModel->getRemoteId())] = true;
                    $unsubsriberModel = $unsubsriberModel->next();
                }
            }
            
            while ($remoteModel) {
                if (!isset($unsubscribers[intval($remoteModel->getId())])) {
                    $id = strtolower(trim($remoteModel->getEmail()));
                    $remote[$id] = array(
                        'id'        => $remoteModel->getId(),
                        'name'      => $remoteModel->getFullName(),
                    );
                    
                }
                $remoteModel = $remoteModel->next();
            }
        }
        
        // Read Local Users
        
        $localModel->read();
        $local = array();
        
        if (!$localModel->isEmptyCollection()) {
            while ($localModel) {
                $id = strtolower(trim(utf8_encode($localModel->getEmail())));
                $local[$id] = array(
                    'id'        => $localModel->getId(),
                    'name'      => utf8_encode($localModel->getFullName()),
                    'allowed'   => $localModel->getSubscription() ? true : false,
                );

                $localModel = $localModel->next();
            }
            
        }
        
        // Combine the two result sets
        
        $users = array();
        
        if (count($remote)) {
            foreach ($remote as $email => $data) {
                if (isset($local[$email])) {
                    if ($local[$email]['allowed']) {
                        $users[$email] = array(
                            'name'      => $data['name'],
                            'remote'    => 1,
                            'local'     => 1,
                        );
                        unset($local[$email]);
                    }
                } else {
                    $users[$email] = array(
                        'name'      => $data['name'],
                        'remote'    => 1,
                        'local'     => 0,
                    );
                }
            }
            
        }

        if (count($local)) {
            foreach ($local as $email => $data) {
                if (!isset($users[$email])) {
                    if ($data['allowed']) {
                        $users[$email] = array(
                            'name'      => $data['name'],
                            'remote'    => 0,
                            'local'     => 1,
                        );
                    }
                }
            }
        }
        
        
        // Parse result into a standard data array
        
        $result = array();
        
        if (count($users)) {
            foreach ($users as $email => $data) {
                $result[] = array(
                    'email'     => $email,
                    'name'      => $data['name'],
                    'remote'    => $data['remote'],
                    'local'     => $data['local'],
                );
            }
        }
        
        $this->items = $result;
        
        if (count($this->items)) {
            $this->pointer = 0;
            return true;
        } else {
            $this->pointer = null;
            return false;
        }
    }
    
    public function unsubscribe($email) {
        $remoteModel = new CbaRemoteIdentityModel();
        $remoteModel->setEmail($email);
        $remoteModel->read();
        if (!$remoteModel->isEmptyCollection()) {
            $unsubsriberModel = new CbaUnsubscriberModel();
            $unsubsriberModel->setRemoteId($remoteModel->getId());
            $unsubsriberModel->read();
            if ($unsubsriberModel->isEmptyCollection()) {
                $unsubsriberModel = new CbaUnsubscriberModel();
                $unsubsriberModel->setRemoteId($remoteModel->getId());
                $unsubsriberModel->save();
                $remoteDeleted = true;
            } else {
                $remoteDeleted = false;
            }
        } else {
            $remoteDeleted = false;
        }
        
        $localModel = new CbaIdentityModel();
        $localModel->setEmail($email);
        $localModel->read();
        if (!$localModel->isEmptyCollection()) {
            if (0 <> $localModel->getSubscription()) {
                $localModel->setSubscription(0);
                $localModel->save();
                $localDeleted = true;
            } else {
                $localDeleted = false;
            }
        } else {
            $localDeleted = false;
        }

        return ($remoteDeleted || $localDeleted);
    }
    
}


