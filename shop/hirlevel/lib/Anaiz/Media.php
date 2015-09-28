<?php

abstract class Media extends Content implements IMedia {

    public function getDirectory() {
        return $this->readAttributeValue('directory');
    }

    public function setDirectory($directory) {
        return $this->writeAttributeValue('directory', $directory);
    }

    public function setUploadFileName($fileName) {
        return $this->writeAttributeValue('upload_file_name', $fileName);
    }

    public function getFileName() {
        return $this->readAttributeValue('file_name');
    }

    public function setFileName($fileName) {
        return $this->writeAttributeValue('file_name', $fileName);
    }

    public function getGalleryId() {
        return $this->readAttributeValue('gallery_id');
    }

    public function setGalleryId($galleryId) {
        return $this->writeAttributeValue('gallery_id', $galleryId);
    }

    public function getOriginalFileName() {
        return $this->readAttributeValue('original_file_name');
    }

    /*public function setOriginalFileName($originalFileName) {
        return $this->writeAttributeValue('original_file_name', $originalFileName);
    }*/

}

