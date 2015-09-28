<?php
/**
 * LocaleManager is a Singleton class used for the sitewide management of locales.
 *
 * @author Zsolt Geresdi
 */

class LocaleManager {
    private static $instance;

    protected $currentLocale = 'hu_HU';
    protected $fallbackLocales = array();

    private function __construct() {}

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class;
        }
        return self::$instance;
    }

    public function __clone() {
        throw new Exception('Cloning a singleton is not allowed.');
    }

    public function getCurrentLocale() {
        return $this->currentLocale;
    }

    public function getFallbackLocales() {
        return $this->fallbackLocales;
    }

    public function setCurrentLocale($locale, $fallbackLocales = NULL) {
        $this->currentLocale = $locale;
        if (is_array($fallbackLocales)) {
            $this->fallbackLocales = $fallbackLocales;
        } else {
            $this->fallbackLocales = array();
        }
    }
}