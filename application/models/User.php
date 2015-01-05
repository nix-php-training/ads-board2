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
        return $this->_db->query("SELECT users.*, roles.name AS role, status.name AS status
                                  FROM users
                                  JOIN status ON users.statusId=status.id
                                  JOIN roles ON users.roleId=roles.id
                                  WHERE users.$field=:$field", $where)->fetch(PDO::FETCH_OBJ);
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
        $this->_db->update($this->table, ["hash" => $hashCode], ["id" => $id]);
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
        return $this->_db->fetchOne($this->table, 'id', ['hash' => $hash]);
    }

    function login()
    {
        $user = $this->getBy('email', $_POST['email']);
        if ($user && password_verify($_POST['password'], $user->password)) {
            if (isset($_POST['remember'])) {
                $expire = 30;
            } else {
                $expire = 0;
            }
            $this->setCookie($user->id, $expire);
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
        return $this->_db->fetchOne($this->table, 'id', [$field => $input]);
    }

    function registration()
    {
        $input = [
            'login' => $_POST['login'],
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ];
        $valid = $this->_validator->validate($input, $this->rules);

        $loginExists = $this->inputExists('login', $input['login']);
        $emailExists = $this->inputExists('email', $input['email']);
        if ($loginExists !== false) {
            unset($valid);
            $valid['login'] = $input['login'] . ' is already exists';
        }
        if ($emailExists !== false) {
            unset($valid);
            $valid['email'] = $input['email'] . ' is already exists';
        }

        if (!is_array($valid)) {
            $data = [
                'login' => $input['login'],
                'email' => $input['email'],
                'password' => password_hash($input['password'], PASSWORD_DEFAULT),
                'startDate' => date('Y-m-d H:i:s'),
                'statusId' => $this->_db->fetchOne('status', 'id', ['name' => 'unconfirmed']),
                'roleId' => $this->_db->fetchOne('roles', 'id', ['name' => 'user']),
            ];
            $this->_db->insert($this->table, $data);
            return true;
        } else {
            return $valid;
        }
    }
}