<?php

class Admin extends Model
{
    public function getUsers()
    {
//        return $this->db->query("SELECT users.*,
//                                        roles.name AS role,
//                                        statuses.name AS status,
//                                        profiles.firstname AS fname,
//                                        profiles.lastname AS lname
//                                  FROM users
//                                    JOIN statuses ON users.statusId=statuses.id
//                                    JOIN roles ON users.roleId=roles.id
//                                    JOIN profiles ON users.id=profiles.userId;")->fetch(PDO::FETCH_ASSOC);

        return $this->db->query("SELECT users.id AS id,
       users.login AS login,
       users.email AS email,
       roles.name AS role,
       statuses.name AS status
FROM users
  JOIN statuses ON users.statusId=statuses.id
  JOIN roles ON users.roleId=roles.id")->fetchAll(PDO::FETCH_ASSOC);
    }
} 