<?php

abstract class AbstractController extends Controller {
    
    protected $navigation = array();

    protected $dbAdapter = null;
    protected $identity = null;

    public function  __construct() {
        $this->startSession();
        $this->initNavigation();
    }

    protected function startSession() {
        session_start();
        $view = $this->getView();
        if (isset($_SESSION['user_id'])) {
            $identity = new CbaIdentityModel();
            //$identity->setDbAdapter($this->getDbAdapter());
            $identity->setId($_SESSION['user_id']);
            $identity->read();
            $this->identity = array(
                'id'        => $identity->getId(),
                'name'      => $identity->getFullName(),
                'email'     => $identity->getEmail(),
                'level'     => $identity->getLevel(),
            );
            $view->fubar = array(
                'class' => '',
                'message' => '',
                'identity' => $this->identity,
                'links' => array(
                    //'Profil' => Request::link('tag', 'profil'),
                    'Kilépés' => Request::link('tag', 'kilepes'),
                ),
            );
            if (isset($_SESSION['login_ok'])) {
                //$view->fubar['message'] = 'Üdvözli Önt az Anaiz Futura CMS!';
                session_unregister('login_ok');
            }
            
        } else {
            $this->identity = null;
            $view->fubar = null;
        }
    }
    
    protected function initNavigation() {
        $this->navigation = array('main' => array());
        $model = new Navigation();
        $model->setGroupId(1);
        $model->setQueryOptions(array('order_by' => 'weight'));
        $model->read();
        if (!$model->isEmptyCollection()) {
            while ($model) {
                $this->navigation['main'][] = array(
                    'label'         => $model->getLabel(),
                    'href'          => $model->getHref(),
                    'target'        => $model->isExternal() ?  '_blank' : '_self',
                    'resource_type' => $model->getResourceType(),
                );
                $model = $model->next();
            }
        }
    }

    public function isAuthorized($action) {
        return true;
    }

    public function run($action) {
        $actionMethod = $action . 'Action';
        if (!method_exists($this, $actionMethod)) {
            $action = 'index';
            $actionMethod = 'indexAction';
        }
        if ($this->isAuthorized($action)) {
            return $this->$actionMethod();
        } else {
            return $this->errorAction();
        }
    }

    public function indexAction() {
        // overwrite this;
    }

    public function errorAction() {
        echo "<pre>Error.</pre>";
    }

    protected function getDbAdapter() {
        if (null == $this->dbAdapter) {
            $this->dbAdapter = Registry::get('db');
        }
        return $this->dbAdapter;
    }

    protected function redirect($controller, $action, $parameters = null ) {
        $paramString = '';
        if (is_array($parameters) && count($parameters)) {
            foreach ($parameters as $key => $value) {
                $paramString .= '&' . $key . '=' . $value;
            }
        }
        header('Location: ' . $controller . '.php?id=' . $action . $paramString);
    }

}

