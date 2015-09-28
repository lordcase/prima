<?php

class Mail_Theme {

    protected $themeName = 'default';
    protected $themePath = 'themes/mail/';
    protected $assetPath = '';


    protected $title = '';
    protected $content = '';
    protected $legal = '';
    
    protected $output = null;
    
    public function setThemeName($themeName) {
        $this->themeName = $themeName;
        return $this;
    }
    
    public function setThemePath($themePath) {
        $this->themePath = rtrim($themePath, ' /') . '/';
        return $this;
    }
    
    public function setAssetPath($assetPath) {
        $this->assetPath = rtrim($assetPath, ' /') . '/';
        return $this;
    }
    
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }
    
    public function setContent($content) {
        $this->content = $content;
        return $this;
    }
    
    public function setLegal($legal) {
        $this->legal = $legal;
        return $this;
    }
    
    public function render($vars = null) {
        if (null === $this->output) {
            $this->renderRaw();
        }
        
        $output = $this->output;
        if (is_array($vars) && !empty ($vars)) {
            foreach ($vars as $key => $value) {
                $output = str_ireplace('%' . $key . '%', $value, $output);
            }
        }
        
        return $output;
    }
    
    protected function renderRaw() {
        ob_start();
        include $this->themePath . $this->themeName . '/' . $this->themeName . '.phtml';
        $this->output = ob_get_clean();
        return $this;
    }
    
}
