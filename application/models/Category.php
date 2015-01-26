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

    public function getCategoryByTitle($title)
    {
        try {
            return $this->db->query('select id from '.$this->table.' WHERE title="' . $title .'"')->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new DatabaseErrorException();
        }

    }

    function addCategory($data)
    {
        $this->db->insert($this->table, $data);
    }


    /**
     * Update category row if category exist
     * or
     * create new row in db
     *
     * @param $params Array('id', 'title', 'description')
     */
    public function saveCategory($params)
    {
        $data = [
            'title' => $params['title'],
            'description' => $params['description']
        ];
        $id = $params['id'];


        $exist = $this->db->query("SELECT id FROM {$this->table} WHERE id={$id}")->fetch(PDO::FETCH_ASSOC);
        if ($exist) {
            $this->updateCategory($data, $id);
        } else {
            $this->addCategory($data);
        }
    }

    /**
     * Update exits category
     *
     * @param $data Array('title', 'description')
     * @param $id
     */
    private function updateCategory($data, $id)
    {
        $this->db->update('categories', $data, ['id' => $id]);
    }

    /**
     * Delete category from db by id
     *
     * @param $id
     */
    public function removeCategory($id)
    {
        $this->db->delete('categories', ['id' => $id]);
    }
}