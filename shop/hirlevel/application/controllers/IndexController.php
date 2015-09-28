<?php

class IndexController extends AbstractController {
    
    public function indexAction() {
        $authorized = ((null != $this->identity) && (3 <= $this->identity['level']));
        if ($authorized) {
            $this->redirect('hirlevel', 'piszkozat');
        } else {
            $this->redirect('tag', 'login');
        }
    }
    
}


