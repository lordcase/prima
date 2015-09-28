<?php

class Request {
    
    protected static $requestAdapter;

    public static function setRequestAdapter($requestAdapter) {
        self::$requestAdapter = $requestAdapter;
    }

    public static function getController() {
        return self::$requestAdapter->getController();
    }

    public static function getAction() {
        return self::$requestAdapter->getAction();
    }

    public static function getParams($ids) {
        return self::$requestAdapter->getParams($ids);
    }

    public static function link($controller, $action, $params = null) {
        return self::$requestAdapter->link($controller, $action, $params);
    }
    
    public static function hasPost($postId = null) {
        if (null === $postId) {
            return !empty($_POST);
        } else {
            return (isset($_POST['form-id']) && (strtolower($postId) == strtolower($_POST['form-id'])));
        }
    }

}

