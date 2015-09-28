<?php
class View {

    protected $layout = 'layout';

    public function setLayout($layout) {
        $this->layout = $layout;
    }

    public function render($script) {
        $scriptFile = ANAIZ_VIEW_PATH . $script . '.phtml';
        ob_start();
        include $scriptFile;
        $this->content = ob_get_contents();
        ob_end_clean();
        include ANAIZ_LAYOUT_PATH . $this->layout . '.phtml';
    }

}

