<?php

class Advertisement extends Model
{
    protected $table = 'advertisements';

    public function addAdvertisement($data)
    {
        $this->db->insert($this->table, $data);
    }

    public function getAllAdvertisements()
    {
        try {
            return $this->db->query('select a.id, a.subject, a.description, a.price, a.creationDate, c.title, u.login from advertisements a
                                  INNER JOIN categories c on a.categoryId=c.id
                                  INNER JOIN users u on a.userId=u.id')->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new DatabaseErrorException();
        }
    }

    public function getAdvertisementById($id)
    {
        try {
            return $this->db->query('select a.id, a.subject, a.description, a.price, a.creationDate, c.title, u.login from advertisements a
                                  INNER JOIN categories c on a.categoryId=c.id
                                  INNER JOIN users u on a.userId=u.id
                                  WHERE a.id='.$id)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new DatabaseErrorException();
        }
    }

}