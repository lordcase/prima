<?php

interface IMedia extends IContent {

    public function getDirectory();
    public function setDirectory($directory);
    public function setUploadFileName($fileName);
    public function getFileName();
    public function setFileName($fileName);
    public function getGalleryId();
    public function setGalleryId($galleryId);
    public function getOriginalFileName();

}

