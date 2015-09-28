<?php

interface IArticle extends IContent {
    public function getUrlId();
    public function setUrlId($urlId);
    public function getTitle();
    public function setTitle($title);
    public function getMetaDescription();
    public function setMetaDescription($description);
    public function getMetaKeywords();
    public function setMetaKeywords($keywords);
    public function getBody();
    public function setBody($body);
    public function getSummary();
    public function setSummary($summary);
    //public function hasMedia();
    //public function getMedia();
    //public function setMedia($media);
    //public function removeMedia();

}