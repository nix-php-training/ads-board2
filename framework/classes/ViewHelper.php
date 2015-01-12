<?php


trait ViewHelper
{

    /**
     * Generate input with @var $attributes = array ('attrib' => 'value')
     * with possibility assign value for html "value" attrib
     *
     * @param $attributes html attributes
     * @param string $value html attribute "value="
     * @return string generated input
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

}