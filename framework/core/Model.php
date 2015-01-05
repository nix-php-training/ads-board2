<?php

class Model
{
    public   $db;
    public  $validator;

    function __construct()
    {
        $this->db = new Database();
        $this->validator = new Validator();
    }
}