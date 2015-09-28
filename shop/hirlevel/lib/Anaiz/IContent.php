<?php

interface IContent extends IResource {
    public function getCreationTimestamp();
    public function getCreationIdentity();
    public function getModificationTimestamp();
    public function getModificationIdentity();
    public function getDeletionTimestamp();
    public function getDeletionIdentity();
    public function getPublicationTimestamp();
    public function setPublicationTimestamp($timestamp);
    public function getPublicationIdentity();
    public function setPublicationIdentity($identity);
    public function getLocale();
    public function setLocale($locale);
}

