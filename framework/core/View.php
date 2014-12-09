<?php

class View
{
    private $_tpl;
    private $_layout;
    private $_data;

    public function render()
    {
        ob_start();

        if (!@include(VWS . $this->_tpl))
            include VWS . 'errors/404.php';

        $data = $this->_data;

        $content = ob_get_clean();

        include $this->_layout;

    }

    public function assign($tpl, $data, $layout)
    {
        $tpl = 'content/' . ucfirst(Tools::normalizeUrl($tpl));

        $this->_tpl = file_exists(VWS . $tpl) ? $tpl : 'errors/404.php';
        $this->_data = $data;
        $this->_layout = $layout;
    }

} 