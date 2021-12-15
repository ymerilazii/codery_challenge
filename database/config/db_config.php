<?php

class DatabaseConfig
{
    protected $hostName;
    protected $userName;
    protected $password;
    protected $dbName;

    public function __construct($dbName = '')
    {
        $this->hostName = 'localhost';
        $this->userName = 'root';
        $this->password = '';
        $this->dbName = $dbName;
    }
}