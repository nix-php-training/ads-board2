<?php

class User extends Model
{
    protected $table = 'users';

    protected $rules = [
        'login' => ['login', 'min_length(3)', 'max_length(32)'],
        'email' => ['email'],
        'password' => ['min_length(3)', 'max_length(32)']
    ];

    function getBy($field, $value)
    {
        $where = [":$field" => $value];
        return $this->db->query("SELECT users.*, roles.name AS role, statuses.name AS status
                                  FROM users
                                  JOIN statuses ON users.statusId=statuses.id
                                  JOIN roles ON users.roleId=roles.id
                                  WHERE users.$field=:$field", $where)->fetch(PDO::FETCH_ASSOC);
    }

    function setCookie($id, $expire = 0)
    {
        if ($expire) {
            $expire = time() + 60 * 60 * 24 * $expire;
        }
        $hashId = $this->hashCoockie($id);
        $hashCode = $this->newHash();
        setcookie('id', $hashId, $expire, '/');
        setcookie('hash', $hashCode, $expire, '/');
        $this->db->update($this->table, ["hash" => $hashCode], ["id" => $id]);
    }

    function generateCode($length = 10)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0, $clen)];
        }
        return $code;
    }

    function newHash($string = 0)
    {
        if (!$string) {
            $string = $this->generateCode();
        }
        return sha1($string);
    }

    function hashCoockie($id)
    {
        return $this->newHash($id . $_SERVER['HTTP_USER_AGENT']);
    }

    function getIdByHash($hash)
    {
        return $this->db->fetchOne($this->table, 'id', ['hash' => $hash]);
    }

    function login($email, $password)
    {
        $user = $this->getBy('email', $email);
        if ($user && password_verify($password, $user['password'])) {
            if (isset($_POST['remember'])) {
                $expire = 30;
            } else {
                $expire = 0;
            }
            $this->setCookie($user['id'], $expire);
            return true;
        } else {
            return false;
        }
    }

    function logout()
    {
        setcookie('id', '', 0, '/');
        setcookie('hash', '', 0, '/');
        session_destroy();
    }

    function inputExists($field, $input)
    {
        return $this->db->fetchOne($this->table, 'id', [$field => $input]);
    }

    function registration($login, $email, $password)
    {
        $input = [
            'login' => $login,
            'email' => $email,
            'password' => $password
        ];
        $result = $this->validator->validate($input, $this->rules);
        if ($result !== true) {
            $valid = $result;
        }

        $loginExists = $this->inputExists('login', $input['login']);
        $emailExists = $this->inputExists('email', $input['email']);
        if ($loginExists !== false) {
            $valid['login'] = $input['login'] . ' is already exists';
        }
        if ($emailExists !== false) {
            $valid['email'] = $input['email'] . ' is already exists';
        }
        if (empty($valid)) {
            $data = [
                'login' => $input['login'],
                'email' => $input['email'],
                'password' => password_hash($input['password'], PASSWORD_DEFAULT),
                'statusId' => $this->db->fetchOne('statuses', 'id', ['name' => 'unconfirmed']),
                'roleId' => $this->db->fetchOne('roles', 'id', ['name' => 'user']),
            ];
            $this->db->insert($this->table, $data);
            return true;
        } else {
            return $valid;
        }
    }

    public function update($fields = [])
    {
        $user = $this->getBy('id', $_SESSION['userId']);

        $valid = [];

        if (isset($fields['login']) && $fields['login'] !== $user['login']) {
            $loginExists = $this->inputExists('login', $fields['login']);
            if ($loginExists !== false) {
                $valid['login'] = $fields['login'] . ' is already exists';
            } else {
                $input ['login'] = $fields['login'];
            }
        }

        if (isset($fields['email']) && $fields['email'] !== $user['email']) {
            $emailExists = $this->inputExists('email', $fields['email']);
            if ($emailExists !== false) {
                $valid['email'] = $fields['email'] . ' is already exists';
            } else {
                $input ['email'] = $fields['email'];
            }
        }


        if (!empty($fields['old-password'])) {
            if (password_verify($fields['old-password'], $user['password'])) {
                if (isset($fields['new-password'])) {
                    $input ['password'] = $fields['new-password'];
                }
            } else {
                $valid['old-password'] = ['Old password password is not correctly'];
            }
        }
        if (isset($input)){
            $rules = $this->getRulesFields($input);
            var_dump($rules);

            var_dump('!!!!!!!!!!!!!');
            var_dump($input);
            $validate = $this->validator->validate($input, $rules);
            var_dump($validate);
        }

        if ($validate!==true){
            $valid = array_merge_recursive($valid, $validate);
        }
        var_dump($valid);
//        if (isset($valid)) {echo 'valid '; var_dump($valid);}
//        if (isset($fields['login']) && $this->validator->validate([$fields['new-password']], ['password' => $this->rules['password']]))
        //        $this->db->update($this->table, $query, ['id' => $_SESSION['userId']]);

    }

    public function getRulesFields($field = [])
    {
        $rule = [];
        foreach ($field as $k => $v) {
            $rule[$k] = $this->rules[$k];
        }
        return $rule;
    }
}