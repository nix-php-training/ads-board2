<?php

class Model
{
    public $_db;

    function __construct()
    {
        $this->_db = new Database();
    }
}