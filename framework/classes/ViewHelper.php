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

    public function errorToMessage($validate)
    {
        $messages='';
        foreach ($validate as $input){
            foreach ($input as $valid){
                $messages.=$valid.'<br>';
            }
        }
        return $messages;
    }

}