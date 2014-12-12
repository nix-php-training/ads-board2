<?php

class Database
{
    protected $pdo = null;

    public function __construct()
    {
        $confs = Config::get('db');
        $host = $confs['host'];
        $user = $confs['user'];
        $password = $confs['password'];
        $db = $confs['db'];
        $charset = $confs['charset'];

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_PERSISTENT => true
        );

        try {
            $this->pdo = new PDO($dsn, $user, $password, $opt);
        } catch (PDOException $e) {
            die('Bad connection: ' . $e->getMessage());
        }
    }

}