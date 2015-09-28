<?php


/**
 * RemoteIdentityModel accesses the User Table in the remote database of the Fitness Centre.
 * User data is read-only, you cannot use this Model to save or delete data.
 *
 */

class CbaRemoteIdentityModel extends Identity {

    public function getResourceType() {
        // Remote Identites do not have Resource Types. So, if there is an Identity present, return 'default'. If no Identity is present, return null.
        return (null != $this->pointer) ? 'default' : null;
    }
    
    public function setResourceType($resourceType) {
        return $this; // Remote Identites do not have a resource type
    }
    
    public function isDeletable() {
        return false; // Remote Identites cannot be deleted
    }
    
    public function isWritable() {
        return false; // Remote Identites cannot be modified
    }
    
    protected function getDbAdapter() {
        if (null == $this->dbAdapter) {
            if (Registry::exists('remote-db')) {
                $this->dbAdapter = Registry::get('remote-db');
            }
        }
        return $this->dbAdapter;    
    }

}


