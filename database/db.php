<?php
include 'config/db_config.php';

class Database extends DatabaseConfig
{
    private $host;
    private $user;
    private $pass;
    private $dbname;

    protected $connection;
    protected $DatabaseName = "CodeCH"; //Custom Database Name
    protected $sqlQuery;
    public $table_name = "UserInfo"; //Custom Table Name


    protected function loadConfig($dbname = '')
    {
        $this->connection = null;
        $this->sqlQuery = null;
        $dbconfig = new DatabaseConfig($dbname);
        $this->host = $dbconfig->hostName;
        $this->user = $dbconfig->userName;
        $this->pass = $dbconfig->password;
        $this->dbname = $dbconfig->dbName;
        $dbconfig = null;
    }

    public function connect()
    {
        $this->loadConfig();
        if (empty($this->dbname)) {
            try {
                $this->connection = new PDO("mysql:host=$this->host", $this->user, $this->pass);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connection = $this->initialize_db($this->connection, $this->DatabaseName);
                if ($this->connection instanceof PDO) {
                    return $this->connection;
                }
            } catch (PDOException $e) {
                return "Connection failed: " . $e->getMessage();
            }
        } else {
            try {
                $this->connection = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $this->connection;
            } catch (PDOException $e) {
                return "Connection failed: " . $e->getMessage();
            }
        }
        return null;
    }

    protected function initialize_db($conn, $dbname)
    {
        $this->sqlQuery = "CREATE DATABASE IF NOT EXISTS $dbname";
        $conn->query($this->sqlQuery);
        $this->sqlQuery = null;
        $this->dbname = $dbname;
        $this->sqlQuery = "USE $dbname";
        $conn->query($this->sqlQuery);
        $this->sqlQuery = null;
        return $this->initialize_table($conn);
    }

    protected function initialize_table($conn)
    {
        $this->sqlQuery = "CREATE TABLE IF NOT EXISTS $this->table_name(
    id INT(6) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(16) NOT NULL,
    martialstatus VARCHAR(40) NOT NULL
);";
        $conn->query($this->sqlQuery);
        $this->sqlQuery = null;
        return $conn;
    }

    public function disconnect()
    {
        $this->connection = null;
        $this->host = null;
        $this->user = null;
        $this->pass = null;
        $this->sqlQuery = null;
        $this->dbname = null;
    }
}