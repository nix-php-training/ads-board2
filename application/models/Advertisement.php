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
        return $this->db->query('select a.subject, a.description, a.price, a.creationDate, c.title, u.login from advertisements a
                                  INNER JOIN categories c on a.categoryId=c.id
                                  INNER JOIN users u on a.userId=u.id')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function splitCreationDate($ads)
    {
        foreach ($ads as $v)
        {
            var_dump($v['creationDate']);
            $dateAndTime = explode( ' ', $v['creationDate']);
            var_dump($dateAndTime);
            $v['creationDate'] = $dateAndTime[0];
            $v['creationTime'] = $dateAndTime[1];

        }
        return $ads;
    }

}