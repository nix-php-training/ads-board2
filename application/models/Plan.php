<?php

class Plan extends Model
{
    private $table = 'plans';

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
        $data = [
            'name' => $params['name'],
            'price' => $params['price'],
            'term' => $params['term'],
            'posts' => $params['posts']
        ];

        $id = $params['id'];

        $exist = $this->db->query("SELECT id FROM {$this->table} WHERE id={$id}")->fetch(PDO::FETCH_ASSOC);
        if ($exist) {
            $this->updatePlan($data, $id);
        } else {
            $this->createPlan($data);
        }
    }

    /**
     * Create new plan
     *
     * @param $data Array('name', 'price', 'term', 'posts')
     */
    private function createPlan($data)
    {
        $this->db->insert($this->table, $data);
    }

    /**
     * Update exist plan
     *
     * @param $data Array('name', 'price', 'term', 'posts')
     * @param $id
     */
    private function updatePlan($data, $id)
    {
        $this->db->update($this->table, $data, ['id' => $id]);
    }

    /**
     * Delete plan from db by id
     *
     * @param $id
     */
    public function removePlan($id)
    {
        $this->db->delete($this->table, ['id' => $id]);
    }
} 