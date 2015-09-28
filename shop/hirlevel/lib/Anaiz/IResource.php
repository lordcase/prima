<?php

interface IResource {
    public function getResourceType();
    public function setResourceType($resourceType);
    public function next();
    public function prev();
    public function first();
    public function last();
    public function isEmptyCollection();
    public function getCollectionLength();
    public function isReadable();
    public function isWritable();
    public function isDeletable();
    public function getAttribute($attribute);
    public function setAttribute($attribute, $value);
    public function getAttributes();
    public function setAttributes($attributes);
    public function setDbAdapter(IDbAdapter $dbAdapter);
    public function getQueryOptions();
    public function setQueryOptions($options);
    public function getId();
    public function setId($id);
    public function isModified(); // returns true if the object has been modified, but not yet saved
    public function isDeleted();
    public function read();
    public function save();
    //public function saveAll();
    public function delete();
    //public function deleteAll();
    public function install();
    public function uninstall();
}
