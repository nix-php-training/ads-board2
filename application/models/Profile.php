<?php

class Profile extends Model
{

    protected $table = 'profiles';

    protected $rules = [
        'firstname' => ['min_length(3)', 'max_length(32)'],
        'lastname' => ['min_length(3)', 'max_length(32)'],
        'birthdate' => ['date', 'min_length(3)', 'max_length(32)'],
        'phone' => ['numeric', 'exact_length(13)'],
        'skype' => ['min_length(3)', 'max_length(32)']
    ];

    public function getProfile($id)
    {
        return $this->db->fetchRow($this->table, ['*'], ['userId'=>$id]);
    }

    public function update($input, $id)
    {
        $this->db->update($this->table, $input, ['id'=> $id]);
    }

    public function validate($input)
    {
        $rules = $this->getCutRules($input, $this->rules);
        return $this->validator->validate($input, $rules);
    }

}