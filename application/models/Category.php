<?php

class Category extends Model
{
    protected $table = 'categories';

    public function getCategoriesBy($data = [])
    {
        if (isset($data)) {
            return $this->db->fetchAll($this->table, $data);
        }

        return $this->db->fetchAll($this->table, ['*']);
    }

    public function addCategory($title, $desc)
    {
        $data = [
            'title' =>$title,
            'description' => $desc
        ];
        $this->db->insert($this->table, $data);
    }

}