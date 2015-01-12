<?php


trait ViewHelper
{

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

}