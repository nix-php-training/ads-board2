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
//    public function generateInput($attributes, $value = "")
//    {
//        $tag = '<input ';
//        foreach ($attributes as $attr => $val) {
//            $tag .= $attr . '="' . $val . '" ';
//        }
//        if (!empty($value)) {
//            $tag .= 'value=' . $value;
//        }
//        $tag .= ' data-toggle="popover" data-trigger="focus" title="Dismissible popover" data-content="And here\'s some amazing content. It\'s very engaging. Right?"/>';
//        return $tag;
//    }

    public function generateInput($attributes, $errorMessage = "", $value = "")
    {
        $tagStart = "";
        $tagEnd = "";


        if (!empty($errorMessage)){
            foreach($errorMessage as $k = > $v){
                $error =
            }
            $tagStart .= "<div class='form-group has-warning'><label class='control-label' for='inputWarning1'>$error</label>";
            $tagEnd .= "</div>";
        } ;
        $input = "<input ";
        foreach ($attributes as $attr => $val) {
            $input .= $attr . '="' . $val . '" ';
        }
        if (!empty($value)) {
            $input .= 'value=' . $value;
        }
        $input .= ' data-toggle="popover" data-trigger="focus" title="Dismissible popover" data-content="And here\'s some amazing content. It\'s very engaging. Right?"/>';
        return $tagStart.$input.$tagEnd;
    }

//
//
//<input type="text" class="form-control" id="inputWarning1">
//</div>

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