<?php

/**
 * TagController, a felhasználókkal ("tagokkal") kapcsolatos műveletekhez.
 */

class TagController extends AbstractController {
    
    public function  isAuthorized($action) {
        switch ($action) {
            case 'login':
            case 'error':
                $authorized = true;
                break;
            case 'profil':
                $authorized = ((null != $this->identity) && (3 <= $this->identity['level']));
                break;
            default:
                $authorized = ((null != $this->identity) && (3 <= $this->identity['level']));
                break;
        }
        return $authorized;
    }
    
    public function loginAction() {
        $view = $this->getView();
        $view->setLayout('denied');
        $view->showNavigation = false;

        if (isset($_POST['email'])) {
            $identity = new CbaIdentityModel();
            $identity->setEmail(trim($_POST['email']));
            $identity->setRawPassword(trim($_POST['password']));
            $identity->read();
            if ($identity->getId()) {
                $_SESSION['user_id'] = $identity->getId();
                $_SESSION['login_ok'] = 'login_ok';
                $this->redirect('hirlevel', 'index');
            } else {
                $view->message = 'Belépés sikertelen, helytelen adatok.';
                $view->data['email'] = htmlspecialchars(trim($_POST['email']));
            }
        }

        $view->render('tag/login');
    }
    
    public function kilepesAction() {
        session_unregister('user_id');
        $this->redirect('tag', 'login');
    }
    
    public function profilAction() {
        $view = $this->getView();
        $view->setLayout('admin');
        $view->showNavigation = true;

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
        $view->render('tag/profil');
    }

}