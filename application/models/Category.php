<?php

class Category extends Model
{
    protected $table = 'categories';

    function getCategoriesBy($data = [])
    {
        if(isset($data)) return $this->db->fetchAll($this->table,$data);
        return $this->db->fetchAll($this->table,['*']);
    }

    function addCategory($title, $desc)
    {
        $data = [
            'title' =>$title,
            'description' => $desc
        ];
        $this->db->insert($this->table,$data);
    }

}