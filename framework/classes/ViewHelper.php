<?php

class ViewHelper
{
    public static function generateMessageData($code)
    {

        switch ($code) {
            case 1:
                $data = array('msg' => 'Greetings! You are registered now!', 'code' => 'success');
                break;
            case 2:
                $data = array('msg' => 'User with this email is already registered!', 'code' => 'danger');
                break;
            case 3:
                $data = array('msg' => 'Something wrong! You are not registered!', 'code' => 'danger');
                break;
            default:
                $data = [];
                break;
        }

        return $data;
    }
} 