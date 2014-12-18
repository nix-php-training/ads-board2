<?php

class Acl
{
    protected $access = false;

    public function isAllow($controller, $action)
    {
        $rules = Config::get('acl');
        foreach ($rules[$controller][$action] as $k => $v) {
            if ($v == $_SESSION['userRole'] || $v == 'all') {
                $this->access = true;
            }
        }
        return $this->access;
    }
}