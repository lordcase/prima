<?php

abstract class Gallery extends Content implements IGallery {

    protected $itemClass = 'Media';
    protected $galleryItems = array();
    protected $itemTransporter = null;

    public function getTitle() {
        return $this->readAttributeValue('title');
    }

    public function setTitle($title) {
        return $this->writeAttributeValue('title', $title);
    }

    public function read() {
        parent::read();
        $this->readItems();
    }

    public function getRawItems() {
        return $this->galleryItems;
    }

    protected function readItems() {
        $itemClass = $this->getItemClass();
        $item = new $itemClass();
        $item->setGalleryId($this->getId());
        $itemTransporter = $this->getItemTransporter();
        $this->galleryItems = $itemTransporter->query('MultiSelect', $item, array('order_by' => 'publication_timestamp ASC'));
    }

    public function delete() {
        if ($this->getId()) {
            if (0 == count($this->galleryItems)) {
                $this->readItems();
            }

            // delete gallery galleryItems

            if (0 != count($this->galleryItems)) {
                $itemClass = $this->getItemClass();
                foreach ($this->galleryItems as $itemData) {
                    $item = new $itemClass();
                    $item->setDbAdapter($this->dbAdapter);
                    $item->setId($itemData['id']);
                    $item->delete();
                }
                $this->galleryItems = array();
            }

            // remove galleryId from parent Articles

            $article = new Article();
            $article->setDbAdapter($this->dbAdapter);
            $article->setGalleryId($this->getId());
            $article->read();
            while ($article->getId()) {
                $article->setGalleryId(0);
                $article->save();
                $article = new Article();
                $article->setDbAdapter($this->dbAdapter);
                $article->setGalleryId($this->getId());
                $article->read();
            }

            parent::delete();

        }
    }

    protected function getItemClass() {
        return $this->itemClass;
    }

    protected function getItemTransporter() {
        if (null === $this->itemTransporter) {
            if (null !== $this->dbAdapter) {
                $transporterClass = $this->itemClass . '_' . $this->dbAdapter->getDbType();
                if (class_exists($transporterClass)) {
                    $this->itemTransporter = new $transporterClass;
                    $this->itemTransporter->setDbAdapter($this->dbAdapter);
                } else {
                    throw new Exception('Cannot get DbTransporter: file ' . $transporterFile . ' not found.');
                }
            } else {
                throw new Exception('Cannot get DbTransporter: DbAdapter is not set.');
            }
        }
        return $this->itemTransporter;
    }
}

