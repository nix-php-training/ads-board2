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

    /**
     * Extract all posts from db with link at image
     *
     * @return mixed Array('id', 'subject', 'price', 'creationDate', 'userId', 'category', 'userLogin', 'link')
     */
    public function getAds()
    {
        return $this->db->query("SELECT
  subject,
  price,
  creationDate,
  userId,
  advertisements.id         AS id,
  categories.title          AS category,
  users.login               AS userLogin,
  advertisementsImages.link AS link
FROM advertisements
  JOIN categories ON categoryId = categories.id
  JOIN users ON userId = users.id
  JOIN advertisementsImages ON advertisements.id = advertisementsImages.advertisementId
GROUP BY id")->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Remove post and related images by id
     *
     * @param $id
     */
    public function removeAdvertisement($id)
    {
        $this->db->query("DELETE advertisements, advertisementsImages
FROM advertisements
  JOIN advertisementsImages ON advertisements.id = advertisementsImages.advertisementId
WHERE advertisements.id={$id}");
    }
}