<?php

class Admin extends Model
{
    public function getUsers()
    {
        return $this->db->query("SELECT users.id AS id,
       users.login AS login,
       users.email AS email,
       roles.name AS role,
       statuses.name AS status
FROM users
  JOIN statuses ON users.statusId=statuses.id
  JOIN roles ON users.roleId=roles.id")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function banUser($id)
    {
        $this->db->update('users', ['statusId' => '3'], ['id' => $id]);
    }

    public function unbanUser($id)
    {
        $this->db->update('users', ['statusId' => '2'], ['id' => $id]);
    }

    public function getPlans()
    {
        return $this->db->query("SELECT id, name, price, term, posts FROM plans")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function savePlan($params)
    {
        $exist = $this->db->query("SELECT id FROM plans WHERE id={$params['id']}")->fetch(PDO::FETCH_ASSOC);
        if ($exist) {
            $this->updatePlan($params);
        } else {
            $this->createPlan($params);
        }
    }

    private function createPlan($params)
    {
        $this->db->insert('plans', $params);

    }

    private function updatePlan($params)
    {
        $this->db->update('plans', [
            'name' => $params['name'],
            'price' => $params['price'],
            'term' => $params['term'],
            'posts' => $params['posts']
        ], ['id' => $params['id']]);
    }

    public function removePlan($id)
    {
        $this->db->delete('plans', ['id' => $id]);
    }
}