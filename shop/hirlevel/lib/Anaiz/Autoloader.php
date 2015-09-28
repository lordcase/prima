<?php

class Autoloader {
    
    protected static $classPaths = array();

    /**
     * Attempts to load the class file, from any of the class paths previously added by calling the static method addClassPath().
     * When searching for the class file, all underscores ('_') in the classname are replaced by slashes ('/'), and the extension '.php' is added.
     * Then this string is added to each registered path (in the order they were added), and the first found file is included.
     * 
     * The return value is either true or false, depending whether a matching file was found or not.
     * 
     * This method should be registerd in the Kickstart file by calling the following:
     * spl_autoload_register(array('Autoloader', 'loadClass'));
     * 
     * @param string $className     Name of the class to be loaded.
     * @return boolean
     */
    public static function loadClass($className) {
        
        $classFileFound = false;
        if (!empty (self::$classPaths)) {
            $classFile = str_replace('_', '/', $className) . '.php';
            foreach (self::$classPaths as $classPath) {
                if ((null === $classPath['fragment']) || (false !== strpos($className, $classPath['fragment']))) {
                    if (file_exists($classPath['path'] . '/' . $classFile)) {
                        require_once $classPath['path'] . '/' . $classFile;
                        $classFileFound = true;
                        break;
                    }
                }
            }
        }
        return $classFileFound;
    }
    
    /**
     * Registers a path where the autoloader should look for class files.
     * 
     * If an optional second parameter is provided, only classes that contain that string in their names will be loaded from this particular path. Matching is case-sensitive.
     * 
     * For example, if you specify this:
     * 
     *   Autoloader::addClassPath('path/to/my/model/files', 'Model')
     * 
     * the Autoloader will look for "FooModel", "ModelFoo", "FooModelBar" in path/to/my/model/files, but will not look for "FooBar" or "Foo-model" there.
     * 
     * @param string $path                  The class file path. A trailing slash is optional.
     * @param string $classNameFragment     Optional class name fragment to limit the path to a specific group of classes.
     */
    public static function addClassPath($path, $classNameFragment = null) {
        self::$classPaths[] = array(
            'path'      => rtrim($path, '\\/ '),
            'fragment'  => $classNameFragment,
        );
    }


    /**
     * Returns the contents of a layout file. The layout file should be located in ANAIZ_LAYOUT_PATH. A '.phtml' extension is added to the layout name. If the file is not found, null is returned.
     * @param string $layoutName
     * @return string
     */
    /*public static function loadLayout($layoutName) {
        return self::loadTemplate(ANAIZ_LAYOUT_PATH . $layoutName . '.phtml');
    }*/
    
    /**
     * Returns the contents of a View file. The view file should be located in ANAIZ_VIEW_PATH. A '.phtml' extension is added to the view name. If the file is not found, null is returned.
     * @param string $viewName
     * @return string
     */
    /*public static function loadView($viewName) {
        return self::loadTemplate(ANAIZ_VIEW_PATH . $viewName . '.phtml');
    }*/
    
    /**
     * Returns the contents of a generic template file. If the file is not found, null is returned.
     * @param string $templateFile
     * @return string
     */
    /*public static function loadTemplate($templateFile) {
        if (file_exists($templateFile)) {
            ob_start();
            include $templateFile;
            return ob_get_clean();
        } else {
            return null;
        }
    }*/
}