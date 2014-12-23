<?php

class Acl
{
    protected $access = false;

    function __construct()
    {
        Auth::authentication();
    }

    public function isAllow($controller, $action)
    {
        $rules = Config::get('acl');
        if (!empty($rules) && isset($rules[$controller][$action])) {
            foreach ($rules[$controller][$action] as $k => $v) {
                if ($v == $_SESSION['userRole'] || $v == 'all') {
                    $this->access = true;
                }
            }
        }
        return $this->access;
    }
}