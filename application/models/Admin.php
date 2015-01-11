<?php

class Admin extends Model
{
    //--------- User functions--------------
    /**
     * Extract all users from db
     *
     * @return mixed Array('id', 'login', 'email, 'role', 'status')
     */
    public function getUsers()
    {
        return $this->db->query("SELECT
  users.id      AS id,
  users.login   AS login,
  users.email   AS email,
  roles.name    AS role,
  statuses.name AS status
FROM users
  JOIN statuses ON users.statusId = statuses.id
  JOIN roles ON users.roleId = roles.id")->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Set status 'banned' for user by id
     *
     * @param $id
     */
    public function banUser($id)
    {
        $this->db->update('users', ['statusId' => '3'], ['id' => $id]);
    }

    /**
     * Set status 'registered' for user by id
     * Don't pass user with status 'unregistered'
     *
     * @param $id
     */
    public function unbanUser($id)
    {
        $this->db->update('users', ['statusId' => '2'], ['id' => $id]);
    }

    //--------- Plan functions--------------

    /**
     * Extract all plans from db
     *
     * @return mixed Array ('id', 'name', 'price', 'term', 'post')
     */
    public function getPlans()
    {
        return $this->db->query("SELECT id, name, price, term, posts FROM plans")->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Update plan row if plan exist
     * or
     * create new row in db
     *
     * @param $params
     */
    public function savePlan($params)
    {
        $exist = $this->db->query("SELECT id FROM plans WHERE id={$params['id']}")->fetch(PDO::FETCH_ASSOC);
        if ($exist) {
            $this->updatePlan($params);
        } else {
            $this->createPlan($params);
        }
    }

    /**
     * Create new plan
     *
     * @param $params Array('name', 'price', 'term', 'posts')
     */
    private function createPlan($params)
    {
        $data['name'] = $params['name'];
        $data['price'] = $params['price'];
        $data['term'] = $params['term'];
        $data['posts'] = $params['posts'];

        $this->db->insert('plans', $data);
    }

    /**
     * Update exist plan
     *
     * @param $params Array('name', 'price', 'term', 'posts')
     */
    private function updatePlan($params)
    {
        $this->db->update('plans', [
            'name' => $params['name'],
            'price' => $params['price'],
            'term' => $params['term'],
            'posts' => $params['posts']
        ], ['id' => $params['id']]);
    }

    /**
     * Delete plan from db by id
     *
     * @param $id
     */
    public function removePlan($id)
    {
        $this->db->delete('plans', ['id' => $id]);
    }

    //--------- Category functions--------------

    /**
     * Extract all categories from db
     *
     * @return mixed Array('id', 'title', 'description')
     */
    public function getCategories()
    {
        return $this->db->query("SELECT id, title, description FROM categories")->fetchAll(PDO::FETCH_ASSOC);
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
        $exist = $this->db->query("SELECT id FROM categories WHERE id={$params['id']}")->fetch(PDO::FETCH_ASSOC);
        if ($exist) {
            $this->updateCategory($params);
        } else {
            $this->createCategory($params);
        }
    }

    /**
     * Create new category
     *
     * @param $params Array('title', 'description')
     */
    private function createCategory($params)
    {
        $data['title'] = $params['title'];
        $data['description'] = $params['description'];

        $this->db->insert('categories', $data);
    }

    /**
     * Update exits category
     *
     * @param $params Array('title', 'description')
     */
    private function updateCategory($params)
    {
        $this->db->update('categories', [
            'title' => $params['title'],
            'description' => $params['description']
        ], ['id' => $params['id']]);
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

    //--------- Advertisements functions--------------

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
    public function removeAds($id)
    {
        $this->db->query("DELETE advertisements, advertisementsImages
FROM advertisements
  JOIN advertisementsImages ON advertisements.id = advertisementsImages.advertisementId
WHERE advertisements.id={$id}");
    }
}