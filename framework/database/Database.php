<?php

class Database
{
    protected $pdo = null;
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $db = 'test';
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