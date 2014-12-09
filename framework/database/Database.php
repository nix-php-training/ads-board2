<?php

class Database
{
    protected $pdo = null;
    private $host = 'localhost';
    private $user = 'root';
    private $password = 'root';
    private $db = 'frame';
    private $charset = 'utf8';

    public function __construct()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_PERSISTENT => true
        );

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->password, $opt);
        } catch (PDOException $e) {
            die('Bad connection: ' . $e->getMessage());
        }
    }

}

/**
 * Class UserConnection
 */
class UserConnection extends Database
{

    /**
     * @param $user
     * @return int
     */
    public function register($user)
    {
        if (!$this->extract($user['email'])) {
            $query = "INSERT INTO user (username, email, password) VALUES (:username, :email, :password)";
            $sth = $this->pdo->prepare($query);
            $sth->bindParam(':username', $user['name']);
            $sth->bindParam(':email', $user['email']);
            $sth->bindParam(':password', $user['password']);
            if ($sth->execute())
                return 1; // ok
            else
                return 3; // unknown error
        } else {
            return 2; // user already exist
        }
    }

    /**
     * @param $email
     * @return mixed
     */
    public function extract($email)
    {
        $query = "SELECT email FROM user WHERE email=?";
        $sth = $this->pdo->prepare($query);
        $sth->execute(array($email));

        return $sth->fetch();
    }
}