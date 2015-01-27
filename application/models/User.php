<?php

class User extends Model
{
    protected $table = 'users';
    protected $linksTable = 'confirmationLinks';
    protected $rules = [
        'login' => ['login', 'min_length(3)', 'max_length(32)', 'required', 'unique'],
        'email' => ['email', 'required', 'unique'],
        'password' => ['min_length(3)', 'max_length(32)', 'required']
    ];

    function getBy($field, $value, $table = 'users')
    {
        $where = [":$field" => $value];
        return $this->db->query("SELECT users.*, roles.name AS role, statuses.name AS status, confirmationLinks.link
                                  FROM users
                                  JOIN statuses ON users.statusId=statuses.id
                                  JOIN roles ON users.roleId=roles.id
                                  JOIN confirmationLinks ON users.id=confirmationLinks.userId
                                  WHERE $table.$field=:$field", $where)->fetch(PDO::FETCH_ASSOC);
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

    function getIdByHash()
    {
        $hash = $_COOKIE['hash'];
        return $this->db->fetchOne($this->table, 'id', ['hash' => $hash]);
    }

    function login($email, $password)
    {
        $user = $this->getBy('email', $email);
        if ($user && password_verify($password, $user['password']) && $user['status'] === 'registered') {
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
        $error = $this->validator->validate($input, $this->rules, $this->table);

        if (empty($error)) {
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
            return $error;
        }
    }

    public function update($fields)
    {
        $user = $this->getBy('id', $_SESSION['userId']);
        $error = [];
        $validate = [];

        if ($fields['login']!==$user['login'])
            $input['login'] = $fields['login'];
        if ($fields['email']!==$user['email'])
            $input['email'] = $fields['email'];

        if (!empty($fields['old-password'])) {
            if (password_verify($fields['old-password'], $user['password'])) {
                if (isset($fields['new-password'])) {
                    $input ['password'] = $fields['new-password'];
                }
            } else {
                $error['old-password'] = 'Old password password is not correctly';
            }
        }
        if (isset($input)) {
            $rules = $this->getCutRules($input, $this->rules);
            $validate = $this->validator->validate($input, $rules, $this->table);
        }

        $error = array_merge_recursive($error, $validate);

        if (empty($error) && !empty($input)) {
            if (isset($input ['password']))
                $input ['password'] = password_hash($input ['password'], PASSWORD_DEFAULT);
            $this->db->update($this->table, $input, ['id' => $user['id']]);
            return true;
        } elseif (empty($error)) {
            return true;
        } else {
            return $error;
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
        $user = $this->getBy('link', $link, 'confirmationLinks');//getting user data by link from confirmation email
        switch ($user['status']) {

            case 'registered'://implement constants!
                return true;
                break;
            case 'unconfirmed':
                return false;
                break;
            default:
                echo "Your link is invalid";
        }
    }

    function changeStatus($link)
    {
        $user = $this->getBy('link', $link,
            'confirmationLinks');//getting object with user data by confirmation link from email
        $this->db->query("UPDATE users SET statusId = '2' WHERE id = {$user['id']}");//changing user status on 2 - registered(by default: 1-unconfirmed), also available 3- banned
        $this->db->query("UPDATE users SET confirmDate = NOW() WHERE id = {$user['id']}");
        $this->db->query("UPDATE users SET statusId = '2' WHERE id = {$user['id']}");
    }

    function getFreePlan($link)
    {
        $user = $this->getBy('link', $link,
            'confirmationLinks');//getting object with user data by confirmation link from email
        $planName = $this->db->fetchOne('plans','id',['name' => 'free']);
        $adsTotal = $this->db->fetchOne('plans','posts',['name' => 'free']);
        $price = $this->db->fetchOne('plans','price',['name' => 'free']);
        $this->db->query("INSERT INTO currentPlan (price,adsCounter,planId,userId)
                            VALUES ({$price},{$adsTotal},{$planName},{$user['id']})");
    }

    function changePlan($planType)
    {
        switch ($planType) {
            case 'pro':
                $price = $this->db->fetchOne('plans','price',['name' => 'pro']);
                $adsTotal = $this->db->fetchOne('plans','posts',['name' => 'pro']);
                $planId = '2';//table plans : 2-pro-Plan(1- Free Plan, user got it by default when confirmed his acc)
                break;
            case 'business':
                $price = $this->db->fetchOne('plans','price',['name' => 'business']);
                $adsTotal = $this->db->fetchOne('plans','posts',['name' => 'business']);
                $planId = '3';//table plans : 3- business plan
                break;
        }
        $transactionId = $_SESSION['transactionId'];
        $hash = $_COOKIE['hash'];
        $user = $this->getBy('hash', $hash);
        $this->db->query("UPDATE currentPlan SET endDate = DATE_ADD(NOW(), INTERVAL 1 MONTH ), price = '{$price}', adsCounter = '{$adsTotal}', planId = '{$planId}' WHERE userId = {$user['id']}");
        $endDate = $this->db->fetchOne('currentPlan','endDate',['userId' => $user['id']]);
        $this->db->query("INSERT INTO payments(date,paymentType,planName,planCost,transactionId,userId) VALUES (DATE_ADD('{$endDate}', INTERVAL -1 MONTH), 'paypal', '{$planType}','{$price}','{$transactionId}',{$user['id']})");
    }

    function checkCurrentPlan()
    {
        $hash = $_COOKIE['hash'];
        $user = $this->getBy('hash',$hash);
        $currentPlan = $this->db->fetchOne('currentPlan','planId',['userId' => $user['id']]);

        /*Start reset-block: resets plan to free if currentPlan.endDate expired*/
        $endDate = $this->db->fetchOne('currentPlan','endDate',['userId' => $user['id']]);//getting expiration date of plan
        if(strtotime($endDate) < time() && $endDate != NULL) {
            $this->resetPlan($user['id']);//reset to free if plan is no more available
        }

        if($endDate == NULL) {
            $endDate = 'Termless';
        }
        /*end reset-block*/

        $disableFree = '';
        $disableBusiness = '';
        $disablePro = '';
        switch ($currentPlan) {
            case '1':
                $disableFree = 'disabled';
                break;
            case '2';
                $disablePro = 'disabled';
                break;
            case '3':
                $disableBusiness = 'disabled';
                break;
        }
        $currentPlan = $this->db->fetchOne('plans', 'name', ['id' => $currentPlan]);
        $currentPlan = strtoupper($currentPlan);
        $planData = [
            'currentPlan' => $currentPlan,
            'disableFree' => $disableFree,
            'disablePro' => $disablePro,
            'disableBusiness' => $disableBusiness,
            'endDate' => $endDate
        ];
        return $planData;
    }

    function resetPlan($userId)//reset user plan to free by userId
    {
        $adsTotal = $this->db->fetchOne('plans','posts',['name' => 'free']);
        $price = $this->db->fetchOne('plans','price',['name' => 'free']);
        $planId = $this->db->fetchOne('plans','id',['name' => 'free']);
        $this->db->query("UPDATE currentPlan SET endDate = NULL, adsCounter = {$adsTotal}, price = {$price}, planId = {$planId}, userId = {$userId} WHERE userId = {$userId}");
    }

    function adsCounter($adsCounter)
    {
        if($adsCounter > 0) {
            $userId = $this->getIdByHash();
            $this->db->query("UPDATE currentPlan SET adsCounter = adsCounter - 1 WHERE userId = {$userId}");
        }
    }

    function checkAdsCounter()
    {
        $userId = $this->getIdByHash();
        $adsCounter = $this->db->fetchOne('currentPlan','adsCounter',['userId' => $userId]);
        return $adsCounter;
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
        $this->db->update($this->table, ['statusId' => '3'], ['id' => $id]);
    }

    /**
     * Set status 'registered' for user by id
     * Don't pass user with status 'unregistered'
     *
     * @param $id
     */
    public function unbanUser($id)
    {
        $this->db->update($this->table, ['statusId' => '2'], ['id' => $id]);
    }

    /**
     * Change password for user by id
     *
     * @param $id
     * @param $password
     */
    public function changePassword($id, $password)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $this->db->update($this->table, ['password' => $password], ['id' => $id]);
    }
}