<?php

class Article extends Content implements IArticle {
    
    public function getUrlId() {
        return $this->readAttributeValue('url_id');
    }

    public function setUrlId($urlId) {
        return $this->writeAttributeValue('url_id', $urlId);
    }

    public function getTitle() {
        return $this->readAttributeValue('title');
    }

    public function setTitle($title) {
        return $this->writeAttributeValue('title', $title);
    }

    public function getMetaDescription() {
        return $this->readAttributeValue('meta_description');
    }

    public function setMetaDescription($description) {
        return $this->writeAttributeValue('meta_description', $description);
    }

    public function getMetaKeywords() {
        $keywordString = $this->readAttributeValue('meta_keywords');
        if ($keywordString) {
            $keywords = explode(',', $keywordString);
            foreach ($keywords as $key => $keyword) {
                $keywords[$key] = trim(strtolower($keyword));
            }
        } else {
            $keywords = array();
        }
        return $keywords;
    }

    public function setMetaKeywords($keywords) {
        if (is_array($keywords)) {
            if (count($keywords)) {
                foreach ($keywords as $key => $keyword) {
                    $keywords[$key] = trim(strtolower($keyword));
                }
            }
            $keywordString = implode(', ', $keywords);
        } else {
            $keywordString = $keywords;
        }
        return $this->writeAttributeValue('meta_keywords', $keywordString);
    }

    public function getBody() {
        return $this->readAttributeValue('body');
    }

    public function setBody($body) {
        return $this->writeAttributeValue('body', $body);
    }

    public function getSummary() {
        return $this->readAttributeValue('summary');
    }

    public function setSummary($summary) {
        return $this->writeAttributeValue('summary', $summary);
    }

    public function getGalleryId() {
        return $this->readAttributeValue('gallery_id');
    }

    public function setGalleryId($galleryId) {
        return $this->writeAttributeValue('gallery_id', $galleryId);
    }

}

