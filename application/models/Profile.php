<?php

class Profile extends Model
{

    protected $table = 'profiles';

    protected $rules = [
        'fullName' => ['min_length(3)', 'max_length(32)'],
        'birthday' => ['date'],
        'phone' => ['numeric', 'min_length(10)'],
        'skype' => ['min_length(3)', 'max_length(32)']
    ];

    public function getProfile($id)
    {
        return $this->db->fetchRow($this->table, ['*'], ['userId' => $id]);
    }

    public function update($input, $id)
    {
        $this->db->update($this->table, $input, ['userId' => $id]);
    }

    public function validate($input)
    {
        $rules = $this->getCutRules($input, $this->rules);
        return $this->validator->validate($input, $rules, $this->table);
    }

    public function addProfile($link)
    {
        $user = new User();
        $userId = $user->getBy('link', $link, 'confirmationLinks');
        $this->db->insert($this->table, ['userId' => $userId['id']]);
    }

}