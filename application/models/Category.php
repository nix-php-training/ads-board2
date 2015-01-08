<?php

class Category extends Model
{
    protected $table = 'categories';

    function getCategoriesBy($data = [])
    {
        if(isset($data)) return $this->db->fetchAll($this->table,$data);
        return $this->db->fetchAll($this->table,['*']);
    }

}