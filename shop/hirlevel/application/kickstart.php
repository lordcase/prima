<?php

// Set up App paths

define('ANAIZ_CLASS_PATH',          'lib/Anaiz/');
define('ANAIZ_APPLICATION_PATH',    'application/');
define('ANAIZ_MODEL_PATH',          ANAIZ_APPLICATION_PATH . 'models/');
define('ANAIZ_CONTROLLER_PATH',     ANAIZ_APPLICATION_PATH . 'controllers/');
define('ANAIZ_VIEW_PATH',           ANAIZ_APPLICATION_PATH . 'views/');
define('ANAIZ_LAYOUT_PATH',         ANAIZ_APPLICATION_PATH . 'layouts/');


// Set up autoloader

require_once ANAIZ_CLASS_PATH . 'Autoloader.php';

Autoloader::addClassPath(ANAIZ_CLASS_PATH);
Autoloader::addClassPath(ANAIZ_CONTROLLER_PATH, 'Controller');
Autoloader::addClassPath(ANAIZ_MODEL_PATH, 'Model');

/*function __autoload($name) {
    Autoloader::loadClass($name);
}*/
spl_autoload_register(array('Autoloader', 'loadClass'));

// Set up Request

class MyRequestAdapter {
    public function link($controller, $action, $params) {
        
        $link = $controller . '.php?id=' . $action;
        
        if (is_array($params) && !empty($params)) {
            foreach ($params as $key => $value) {
                $link .= '&' . $key . '=' . $value;
            }
        }
        return $link;
    }
}
$myRequestAdapter = new MyRequestAdapter();
Request::setRequestAdapter($myRequestAdapter);

// Set up DB adapter

$dbAdapter = new DbAdapter_MySql();
$dbAdapter->connect(array('server' => 'localhost', 'username' => 'cbafitnesssql', 'password' => 'Pzutr56e', 'database' => 'cbafitnessdb'));
Registry::add('db', $dbAdapter);

$remoteDbAdapter = new DbAdapter_MsSql();
$remoteDbAdapter->connect(array('server' => '81.183.210.139:1434', 'username' => 'webuser', 'password' => 'honlapszerk', 'database' => 'wellness'));
Registry::add('remote-db', $remoteDbAdapter);

// Set up a global Settings object

$settings = new Setting();
Registry::add('settings', $settings);

// Lock the Registry

Registry::lock();

// Run Controller

$controllerId = isset($controllerId) ? ucfirst(strtolower($controllerId)) : 'Public';
$controllerClass = $controllerId . 'Controller';

if (class_exists($controllerClass)) {
    $controller = new $controllerClass();
    $id = isset($_GET['id']) ? trim(htmlspecialchars($_GET['id'])) : 'index';
    $controller->run($id);
} else {
    die('Fatal error: Controller Class not found.');
}