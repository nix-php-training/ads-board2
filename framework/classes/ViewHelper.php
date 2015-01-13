<?php


trait ViewHelper
{

    /**
     * Generate input
     *
     * @param $attributes
     * @param string $value
     * @return string
     */
    public function generateInput($attributes, $value = "")
    {
        $tag = '<input ';
        foreach ($attributes as $attr => $val) {
            $tag .= $attr . '="' . $val . '" ';
        }
        if (!empty($value)) {
            $tag .= 'value=' . $value;
        }
        $tag .= ' />';
        return $tag;
    }

    /**
     * Generate error message
     *
     * @param $text
     * @param $type
     * @return string
     */
    public function generateMessage($text, $type = 'info')
    {
        $alerts = ['danger', 'success', 'info', 'warning'];
        $type = (in_array($type, $alerts)) ? $type : 'info';
        return '<div class="alert alert-' . $type . '" role="alert">' . $text . '</div>';
    }

}