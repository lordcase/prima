<?php

class Controller {

    protected $view = null;

    protected function getView() {
        if (null == $this->view) {
            $this->view = new View();
        }
        return $this->view;
    }
}

