<?php

class View
{

    function generate($content, $layout = 'layout.phtml', $data = null)
    {
        ob_start();
        include ROOT_PATH . '/application/views/content/' . $content;
        $content = ob_get_clean();
        include ROOT_PATH . '/application/views/layout/' . $layout;

    }

    function generateError($content, $layout = 'layout.phtml', $data = null)
    {
        ob_start();
        include ROOT_PATH . '/application/views/error/' . $content;
        $content = ob_get_clean();
        include ROOT_PATH . '/application/views/layout/' . $layout;

    }
}