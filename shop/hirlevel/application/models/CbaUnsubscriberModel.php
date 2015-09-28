<?php

/**
 * As the User Table in the Remote Database is read only, we cannot delete unsubscribers from there.
 * So, if a user from that DB is unsubscribed, we store his or her Remote Id in the Local database.
 * 
 * When we retrieve Newsmail Subscriber emails from the Remote Database, we must delete all records with matching "remoteId"-s from this Model.
 * 
 */
class CbaUnsubscriberModel extends Resource {
    
    public function setRemoteId($remoteId) {
        return $this->writeAttributeValue('remote_id', $remoteId);
    }
    
    public function getRemoteId() {
        return $this->readAttributeValue('remote_id');
    }
    
}


