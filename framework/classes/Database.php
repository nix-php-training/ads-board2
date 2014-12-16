<?php
namespace app\core;

class Database
{
    static $DB = null;
    private $db;

    private $host;
    private $driver;
    private $dbname;
    private $user;
    private $password;
    private $charset;

    private function __construct()
    {
        $app = FrontController::getInstance();
        $config = $app->getSettings('db');

        $this->host = $config['host'];
        $this->driver = $config['driver'];
        $this->dbname = $config['dbname'];
        $this->user = $config['user'];
        $this->password = $config['password'];
        $this->charset = $config['charset'];

        $this->connect();

    }

    private function connect()
    { //Подключаемся...
        try {
            $this->db = new \PDO($this->driver . ':host=' . $this->host . '; dbname=' . $this->dbname, $this->user,
                $this->password);
            $this->db->query('SET NAMES ' . $this->charset);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getDB()
    {
        if (empty(self::$DB)) {
            self::$DB = new Database();
        }
        return self::$DB;
    }


    public function select($table, $fieldname = null, $id = null)
    {
        $sql = "SELECT * FROM `$table` WHERE `$fieldname`=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function update($table, $fieldname, $value, $pk, $id)
    {
        $sql = "UPDATE `$table` SET `$fieldname`='{$value}' WHERE `$pk` = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_STR);
        $stmt->execute();
    }

    public function delete($table, $fieldname, $id)
    {
        $sql = "DELETE FROM `$table` WHERE `$fieldname` = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_STR);
        $stmt->execute();
    }

    public function getById($id, $table)
    {
        $sql = "SELECT * FROM `$table` WHERE `id`=:id";
        $smt = $this->db->prepare($sql);
        $smt->execute(array(':id' => $id));
        $data = $smt->fetch(\PDO::FETCH_ASSOC);
        return $data;
    }
}