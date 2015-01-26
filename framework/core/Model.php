<?php

class Model
{
    public $db;
    public $validator;

    function __construct()
    {
        $this->db = new Database();
        $this->validator = new Validator();
    }

    /**
     * @param array $field
     * @param array $rules
     * @return array
     */
    public function getCutRules($field, $rules)
    {
        $cutRule = [];
        foreach ($field as $k => $v) {
            if (isset($rules[$k]))
            $cutRule[$k] = $rules[$k];
        }
        return $cutRule;
    }

}