<?php

class AdminController extends AbstractController {

    public function __construct() {
        parent::__construct();
        $view = $this->getView();
        $identity = $this->identity;
        if (is_array($identity) && isset($identity['password'])) {
            unset($identity['password']);
        }
        $view->identity = $identity;
    }

    public function  isAuthorized($action) {
        switch ($action) {
            case 'index':
            case 'login':
            case 'error':
                $authorized = true;
                break;
            default:
                $authorized = ((null != $this->identity) && (1 <= $this->identity['level']));
                break;
        }
        return $authorized;
    }

    public function indexAction() {
        if ((null != $this->identity) && (1 <= $this->identity['level'])) {
            /*$view = $this->getView();
            $view->setLayout('admin');
            $view->showNavigation = true;
            $view->render('admin/index');*/
            $this->redirect('admin', 'cikkek');
        } else {
            $this->redirect('admin', 'login');
        }
    }

    public function loginAction() {
        $view = $this->getView();
        $view->setLayout('admin');
        $view->showNavigation = false;

        if (isset($_POST['email'])) {
            $identity = new Identity();
            $identity->setDbAdapter($this->getDbAdapter());
            $identity->setEmail(trim($_POST['email']));
            $identity->setRawPassword(trim($_POST['password']));
            $identity->read();
            if ($identity->getId()) {
                $_SESSION['user_id'] = $identity->getId();
                $_SESSION['login_ok'] = 'login_ok';
                $this->redirect('admin', 'cikkek');
            } else {
                $view->message = 'Belépés sikertelen, helytelen adatok.';
                $view->data['email'] = htmlspecialchars(trim($_POST['email']));
            }
        }

        $view->render('admin/login');
    }
    
    public function kilepesAction() {
        session_unregister('user_id');
        $this->redirect('admin', 'index');
    }

    public function profilAction() {
        $view = $this->getView();
        $view->setLayout('admin');
        $view->showNavigation = true;

        /*if (isset($_POST['full_name'])) {
            $newFullName = trim(htmlspecialchars($_POST['full_name']));
            if ($newFullName != $this->identity['name']) {

            }
        }*/

        if (isset($_POST['password'])) {
            $password = htmlspecialchars(trim($_POST['password']));
            $passwordConfirm = htmlspecialchars(trim($_POST['password_confirm']));
            if ($password == $passwordConfirm) {
                $identity = new Identity();
                $identity->setDbAdapter($this->getDbAdapter());
                $identity->setId($this->identity['id']);
                $identity->setRawPassword($password);
                if ($identity->save()) {
                    $view->message = 'Jelszó sikeresen megváltoztatva.';
                } else {
                    $view->message = 'Jelszó mentése sikertelen, nem várt hiba lépett fel.';
                }
            } else {
                $view->message = 'Hiba: a két jelszó nem egyezik!';
            }
        }

        $view->data = $this->identity;
        $view->render('admin/profil');
    }

    public function errorAction() {
        $view = $this->getView();
        $view->setLayout('admin');
        $view->showNavigation = false;
        $view->render('admin/error');
    }
    
    public function menukAction() {
        $view = $this->getView();
        $view->setLayout('admin');
        $view->showNavigation = true;
        $view->items = array(
            array('id' => 1, 'label' => 'Főmenü', 'icon' => 'menu', 'link' => Request::link('admin', 'menu', array('menu' => 1))),
            array('id' => 2, 'label' => 'Alsó menü', 'icon' => 'menu', 'link' => Request::link('admin', 'menu', array('menu' => 2))),
        );
        $view->labels = array(
            'label' => 'Menü',
        );
        
        $view->render('admin/list');
    }

    public function menuAction() {
        $view = $this->getView();
        $view->setLayout('admin');
        $view->showNavigation = true;
        
        $id = intval($_GET['menu']);
        if (in_array($id, array(1, 2))) {
            if (1 == $id) {
                $view->title = 'Menü: Főmenü';
            } else {
                $view->title = 'Menü: Alsó menü';
            }
            
            if (Request::hasPost('list-reorder')) {
                $weights = $_POST['weights'];
                if (is_array($weights) && !empty($weights)) {
                    foreach ($weights as $id => $weight) {
                        $model = new Navigation();
                        $model->setId(intval($id));
                        if ($model->read()) {
                            $weight = intval($weight);
                            if ($weight != $model->getWeight()) {
                                $model->setWeight($weight)->save();
                            }
                        }
                    }
                }
            } elseif (Request::hasPost('list-new-item')) {
                $model = new Navigation();
                if ($model->setGroupId($id)->setQueryOptions(array('order_by' => 'weight DESC', 'limit' => 1))->read()) {
                    $weight = $model->getWeight() + 1;
                } else {
                    $weight = 1;
                }
                $model = new Navigation();
                $model->setLabel('Új menüpont')->setResourceType('secret')->setGroupId($id)->setWeight($weight)->save();
            }
            
            $model = new Navigation();
            $model->setGroupId($id)->setQueryOptions(array('order_by' => 'weight'))->read();
            if (!$model->isEmptyCollection()) {
                $items = array();
                while ($model) {
                    $items[] = array(
                        'id'            => $model->getId(),
                        'label'         => $model->getLabel(),
                        'link'          => Request::link('admin', 'menupont', array('menupont' => $model->getId())),
                        'extras' => array(
                            'visbility'     => ('default' == $model->getResourceType()) ? 'nyilvános' : 'rejtett',
                            'external-link' => $model->isExternal() ? 'igen' : 'nem',
                            'href'          => $model->getHref(),
                        ),
                        'weight'        => $model->getWeight(),
                    );
                    $model = $model->next();
                }
                $view->items = $items;
            } else {
                $view->items = array();
            }
        } else {
            $view->title = 'Nincs ilyen menü';
            $view->items = array();
        }
        $view->labels = array(
            'label'         => 'Megjelenített név',
            'visiblity'     => 'Láthatóság',
            'external-link' => 'Külső oldalra mutat',
            'href'          => 'Webcím',
        );
        $view->buttons = array(
            array('label' => 'Vissza a menükhöz', 'title' => 'Vissza a menükhöz', 'class' => 'cancel-button', 'href' => Request::link('admin', 'menuk', null)),
            array('label' => 'Új menüpont', 'title' => 'Egy új, rejtett menüpont hozzáadása', 'class' => 'new-button submit-button', 'href' => '#list-new-item'),
        );
        $view->forms = array(
            array('id' => 'list-new-item', 'action' => Request::link('admin', 'menu', array('menu' => $id))),
        );
        $view->render('admin/list');
    }
    
    public function menupontAction() {
        $view = $this->getView();
        $view->setLayout('admin');
        $view->showNavigation = true;
        
        if (Request::hasPost('nav-delete')) {
            $model = new Navigation();
            $model->setId(intval($_GET['menupont']));
            $model->read();
            $groupId = $model->getGroupId();
            
            $model = new Navigation();
            $model->setId(intval($_GET['menupont']));
            $model->delete();
            $this->redirect('admin', 'menu', array('menu' => $groupId));
            //$this->menuAction();
            
        } elseif (Request::hasPost('nav-save')) {
            $model = new Navigation();
            $model->setId(intval($_GET['menupont']));
            $model->setLabel(trim(htmlspecialchars($_POST['label'])));
            switch ($_POST['link-type']) {
                case 'external':
                    $model->setExternalUrl(trim(htmlspecialchars($_POST['external-url'])));
                    $model->setController('');
                    $model->setAction('');
                    break;
                case 'article':
                    $model->setExternalUrl('');
                    $model->setController('cikk');
                    $model->setAction(trim(htmlspecialchars($_POST['article-id'])));
                    break;
            }
            $groupId = intval($_POST['group-id']);
            $model->setGroupId($groupId);
            //$model->setWeight(intval($_POST['weight']));
            $model->setWeight(0);
            $model->setResourceType(('default' == $_POST['resource-type']) ? 'default' : 'secret');
            $model->save();
            $view->message = 'Menüpont sikeresen elmentve.';
            
            //$this->menuAction();
            //$this->redirect('admin', 'menu', array('menu' => $model->getGroupId()));
            //$view->render('admin/menupontszerkeszto');
            
        };
            
        $model = new Navigation();
        $model->setId(intval($_GET['menupont']));
        if ($model->read()) {
            $view->data = array(
                'id'            => $model->getId(),
                'label'         => $model->getLabel(),
                'group-id'      => $model->getGroupId(),
                'resource-type' => $model->getResourceType(),
                'external-url'  => $model->getExternalUrl(),
                'article-id'    => $model->getAction(),
                'link-type'     => ('' == $model->getExternalUrl()) ? 'article' : 'external',

            );
            $articleModel = new Article();
            $articleModel->setResourceType('default')->setQueryOptions(array('order_by' => 'title'))->read();
            $view->articles = array();
            if (!$articleModel->isEmptyCollection()) {
                while ($articleModel) {
                    $view->articles[] = array(
                        'id'            => $articleModel->getId(),
                        'title'         => $articleModel->getTitle(),
                        'url-id'        => $articleModel->getUrlId(),
                    );
                    $articleModel = $articleModel->next();
                }
            }
        } else {
            // TODO: handle illegal nav item id
        }

        $view->render('admin/menupontszerkeszto');
    }

    public function cikkekAction() {
        $view = $this->getView();
        $view->setLayout('admin');
        $view->showNavigation = true;

        $pageId = htmlspecialchars($_GET['page']);
        $db = $this->getDbAdapter();
        if ($pageId) {

            $model = new Article();
            $model->setDbAdapter($db);
            $model->setId($pageId);
            $model->read();
            /*if ($model->getUrlId() != $oageId) {
                $model = new Article();
                $model->setDbAdapter($db);
                $model->setUrlId($urlId);
            }*/

            if (Request::hasPost('article-delete')) {
                if (!$model->isEmptyCollection()) {
                    $model->delete();
                }
                $this->redirect('admin', 'cikkek');
            } elseif (isset($_POST['title'])) {
                $body = $_POST['body'];
                $body = html_entity_decode($body, null, 'utf-8');
                $body = strip_tags($body, '<p><a><b><i><strong><em><img><ul><ol><li><h1><h2><h3><h4><h5><h6><br>');
                $body = stripslashes($body);
                $body = preg_replace('#\s*<(/?\w+)\s+(?:on\w+\s*=\s*(["\'\s])?.+?\(\1?.+?\1?\);?\1?|style=["\'].+?["\'])\s*>#is', '<${1}>', $body);
                $model->setBody($body);
                $model->setTitle(htmlspecialchars(trim($_POST['title'])));
                
                $urlId = trim($_POST['url-id']);
                if ('' == $urlId) {
                    $urlId = $model->getTitle();
                }
                if ('' != $urlId) {
                    $urlId = strtr(strtolower($urlId), array('á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ö' => 'o', 'ő' => 'o', 'ú' => 'u', 'ü' => 'u', 'ű' => 'u', ' ' => '_'));
                    $urlId= preg_replace('/([^a-z0-9_]+)/', '', $urlId);
                } else {
                    $urlId = 'ismeretlen_' . time();
                }
                $model->setUrlId($urlId);
                $model->setMetaKeywords(htmlspecialchars(trim($_POST['keywords'])));
                $model->setMetaDescription(htmlspecialchars(trim($_POST['description'])));
                $model->setGalleryId(intval($_POST['gallery_id']));
                $model->setResourceType(('default' == $_POST['resource-type']) ? 'default' : 'secret');
                if ($model->save()) {
                    $view->message = 'Cikk sikeresen elmentve';
                } else {
                    $view->warning = 'Hiba történt a mentés során.';
                }
                
                //$view->render('admin/cikkek');
                //$this->redirect('admin', 'cikkek');
            }
            $view->data = array(
                'id' => $model->getId(),
                'url-id' => $model->getUrlId(),
                'title' => $model->getTitle(),
                'keywords' => implode(', ', $model->getMetaKeywords()),
                'description' => $model->getMetaDescription(),
                'body' => $model->getBody(),
                'gallery_id' => $model->getGalleryId(),
                //'resource-type' => $model->getResourceType(),
            );
            $view->galleries = $this->getGalleries();

            $view->render('admin/cikkszerkeszto');

        } else {
            
            if (Request::hasPost('list-new-item')) {
                $model = new Article();
                $model->setTitle('Új cikk')->setResourceType('secret')->save();
            }    
            
            $model = new Article();
            //$model->setLocale('hu');
            $model->setQueryOptions(array('order_by' => 'title'));
            $model->read();
            
            if (!$model->isEmptyCollection()) {
                $items = array();
                while ($model) {
                    $items[] = array(
                        'id'            => $model->getId(),
                        'label'         => $model->getTitle() ? $model->getTitle() : '[nincs cím]',
                        'link'          => Request::link('admin', 'cikkek', array('page' => $model->getId())),
                        'extras' => array(
                            'visbility'                 => ('default' == $model->getResourceType()) ? 'nyilvános' : 'rejtett',
                            'creation-timestamp'        => $model->getCreationTimestamp(),
                            'modification-timestamp'    => $model->getModificationTimestamp(),
                            
                        ),
                        //'weight'        => $model->getWeight(),
                    );
                    $model = $model->next();
                }
                $view->items = $items;
            } else {
                $view->items = array();
            }
            $view->labels = array(
                'label'                     => 'Cím',
                'visiblity'                 => 'Láthatóság',
                'creation-timestamp'        => 'Létrehozva',
                'modification-timestamp'    => 'Módosítva',
            );
            
            $view->buttons = array(
                array('label' => 'Új cikk', 'title' => 'Egy új, rejtett cikk hozzáadása', 'class' => 'new-button submit-button', 'href' => '#list-new-item'),
            );
            $view->forms = array(
                array('id' => 'list-new-item', 'action' => Request::link('admin', 'cikkek')),
            );
            
            $view->title = 'Cikkek';
            $view->render('admin/list');
        }
    }

    public function kepekAction() {
        $view = $this->getView();
        $view->setLayout('admin');
        $view->showNavigation = true;

        $model = new ImageGallery();
        $model->setQueryOptions(array('order_by' => 'title'));
        $model->read();
        
        if (!$model->isEmptyCollection()) {
            $items = array();
            while ($model) {
                $items[] = array(
                    'id'            => $model->getId(),
                    'label'         => $model->getTitle() ? $model->getTitle() : '[nincs cím]',
                    'link'          => Request::link('admin', 'kepgaleria', array('galeria' => $model->getId())),
                    'extras' => array(),
                    //'weight'        => $model->getWeight(),
                );
                $model = $model->next();
            }
            $view->items = $items;
        } else {
            $view->items = array();
        }
        $view->items[] = array(
            'id'        => 0,
            'label'     => '[Galériába nem sorolt képek]',
            'link'      => Request::link('admin', 'kepgaleria', array('galeria' => 0)),
        );
        $view->labels = array(
            'label'                     => 'Cím',
        );

        $view->buttons = array(
            array('label' => 'Új galéria', 'title' => 'Egy új képgaléria hozzáadása', 'class' => 'new-button submit-button', 'href' => '#list-new-item'),
        );
        $view->forms = array(
            array('id' => 'list-new-item', 'action' => Request::link('admin', 'kepek')),
        );
        $view->title = 'Képgalériák';

        $view->render('admin/list');
    }

    public function kepgaleriaAction() {
        $view = $this->getView();
        $view->setLayout('admin');
        $view->showNavigation = true;

        $db = $this->getDbAdapter();

        $model = new ImageGallery();
        $model->setDbAdapter($db);
        if (isset($_GET['galeria'])) {
            $model->setId(intval($_GET['galeria']));
            if (isset($_POST['delete_id'])) {
                if ((intval($_POST['delete_id']) == $model->getId()) && ($model->getId() >= 1)) {
                    $model->delete();
                    $this->redirect('admin', 'kepek');
                }
            }
        }
        if (isset($_POST['title'])) {
            $model->setTitle(htmlspecialchars(trim($_POST['title'])));
            $model->save();
            $this->redirect('admin', 'kepek');
        } else {
            if (isset($_GET['galeria'])) {
                $model->read();
                $view->data = array(
                    'id' => $model->getId() ? $model->getId() : 0,
                    'title' => $model->getTitle(),
                );
                $view->images = $model->getRawItems();
            } else {
                $view->data = array('id' => null, 'title' => 'Új galéria');
                $view->images = array();
            }
            $view->render('admin/kepgaleria');
        }
    }


    public function kepAction() {
        $view = $this->getView();
        $view->setLayout('admin');
        $view->showNavigation = true;

        $db = $this->getDbAdapter();

        $model = new Image();
        $model->setDbAdapter($db);
        $model->setDirectory('assets/images/content/');
        $model->setId(intval($_GET['image']));
        $model->read();
        if ($model->getFileName()) {
            if (isset($_POST['delete_id'])) {
                if ($model->getId() == $_POST['delete_id']) {
                    $model->delete();
                    $this->redirect('admin', 'kepgaleria', array('galeria' => $model->getGalleryId()));
                }
            }
            if (isset($_POST['gallery_id'])) {
                $model->setGalleryId(intval($_POST['gallery_id']));
                $model->save();
                $this->redirect('admin', 'kepgaleria', array('galeria' => $model->getGalleryId()));
            }
            $view->data = array(

                'id' => $model->getId(),
                'directory' => $model->getDirectory(),
                'file_name' => $model->getFileName(),
                'original_file_name' => $model->getOriginalFileName(),
                'gallery_id' => $model->getGalleryId(),
            );

        }

        $view->galleries = $this->getGalleries();
        $view->render('admin/kep');
    }

    public function kepfeltoltesAction() {
        $view = $this->getView();
        $view->setLayout('admin');
        $view->showNavigation = true;

        if (isset($_FILES['image'])) {
            $db = $this->getDbAdapter();

            $model = new Image();
            $model->setDirectory('assets/images/content/');
            $model->setUploadFileName('image');
            $model->setDbAdapter($db);
            if ($model->save()) {
                $this->redirect('admin', 'kep', array('image' => $model->getId()));
            }

        }
        $view->render('admin/kepfeltoltes');
    }

    protected function getGalleries() {
        // this should be implemented in a Model, not here in the Controller!

        $db = $this->getDbAdapter();

        $model = new ImageGallery();

        $transporterClass = 'ImageGallery_' . $db->getDbType();
        $transporter = new $transporterClass();
        $transporter->setDbAdapter($db);
        $result = $transporter->query('MultiSelect', $model, array('order_by' => 'title'));
        $result[] = array('id' => 0, 'title' => '[Nincs galéria kiválsztva.]');
        return $result;
    }

}

