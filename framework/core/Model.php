<?php

class Model
{
    public   $_db;
    public  $_validator;

    function __construct()
    {
        $this->_db = new Database();
        $this->_validator = new Validator();
    }
}