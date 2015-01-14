<?php

class User extends Model
{
    protected $table = 'users';
    protected $linksTable = 'confirmationLinks';
    protected $rules = [
        'login' => ['login', 'min_length(3)', 'max_length(32)'],
        'email' => ['email'],
        'password' => ['min_length(3)', 'max_length(32)']
    ];

    function getBy($field, $value, $table='users')
    {
        $where = [":$field" => $value];
        return $this->db->query("SELECT users.*, roles.name AS role, statuses.name AS status, confirmationLinks.link
                                  FROM users
                                  JOIN statuses ON users.statusId=statuses.id
                                  JOIN roles ON users.roleId=roles.id
                                  JOIN confirmationLinks ON users.id=confirmationLinks.userId
                                  WHERE $table.$field=:$field", $where)->fetch(PDO::FETCH_OBJ);
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
        if ($user && password_verify($password, $user->password)) {
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
            Registry::set('email', $data['email']);
            return true;
        } else {
            return $valid;
        }
    }

    function putLink($link)
    {
        $userEmail = Registry::get('email');
        $temp = $this->db->query("SELECT id FROM users WHERE email LIKE '$userEmail'")->fetch(PDO::FETCH_OBJ);
        $data = [
            'link' => $link,
            'userId' => $temp->id,
        ];
        $this->db->insert($this->linksTable, $data);
    }

    function checkStatus($link)
    {
        $user = $this->getBy('link', $link,'confirmationLinks');//getting user data by link from confirmation email
        switch($user->status){
            case 'registered'://implement constants!
                return true;break;
            case 'unconfirmed':
                return false;break;
            default:
                echo "Your link is invalid";
        }
    }

    function changeStatus($link)
    {
        $user = $this->getBy('link', $link,'confirmationLinks');//getting object with user data by confirmation link from email
        $this->db->query("UPDATE users SET statusId = '2' WHERE id LIKE '$user->id'");//changing user status on 2 - registered(by default: 1-unconfirmed), also available 3- banned
        $this->db->query("UPDATE users SET confirmDate = NOW() WHERE id LIKE '{$user->id}'");
    }

    function getFreePlan($link)
    {
        $user = $this->getBy('link', $link,'confirmationLinks');//getting object with user data by confirmation link from email
        $this->db->query("INSERT INTO payments (paymentType,price,planId,userId)
                            VALUES ('free','0,0','1','{$user->id}')");
    }

    function changePlan($planType)
    {
        switch($planType){
            case 'pro':
                $price = '99.99';
                $planId = '2';//table plans : 2-pro-Plan(1- Free Plan, user got it by default when confirmed his acc)
                break;
            case 'business':
                $price = '999.9';
                $planId = '3';//table plans : 3- business plan
                break;
        }
        $hash = $_COOKIE['hash'];
        $user = $this->getBy('hash',$hash);
        $this->db->query("UPDATE payments SET paymentType = 'paypal', endDate = DATE_ADD(NOW(), INTERVAL 1 MONTH ), price = '{$price}', planId = '{$planId}' WHERE userId = '{$user->id}'");
    }



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

}