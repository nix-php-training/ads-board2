<?php

class View
{

//    function generate($content, $layout = 'layout.phtml', $data = null)
//    {
//        ob_start();
//        include ROOT_PATH . '/application/views/content/' . $content;
//        $content = ob_get_clean();
//        include ROOT_PATH . '/application/views/layout/' . $layout;
//
//    }
//
//    function generateError($content, $layout = 'layout.phtml', $data = null)
//    {
//        ob_start();
//        include ROOT_PATH . '/application/views/error/' . $content;
//        $content = ob_get_clean();
//        include ROOT_PATH . '/application/views/layout/' . $layout;
//
//    }

    private $_tpl;
    private $_layout;
    private $_data;

    public function render()
    {
        $data = $this->_data;

        ob_start();
        if (!@include(ROOT_PATH . '/application/views/content/' . $this->_tpl))
            include ROOT_PATH . '/application/views/error/error.phtml';
        $content = ob_get_clean();
        include ROOT_PATH . $this->_layout;
    }

    public function assign($tpl, $data, $layout)
    {
        $tpl = strtolower(Tools::normalizeUrl($tpl, 'phtml'));

        $this->_tpl = file_exists(ROOT_PATH . '/application/views/content/' . $tpl) ? $tpl : null;

        ChromePhp::log($this->_tpl);

        $this->_data = $data;
        $this->_layout = $layout;
    }
}