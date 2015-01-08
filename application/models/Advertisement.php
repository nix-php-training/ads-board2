<?php

class Advertisement extends Model
{
    protected $table = 'advertisements';

    function addAdvertisement($data)
    {
        $this->db->insert($this->table,$data);
    }

}