<?php


class DB {
    private $host = '127.0.0.1';
    private $port='3306';
    private $user = 'dev';
    private $pass = 'Chancery@1';
    private $dbname = 'slim-api';

    public function connect()
    {
        try {
            $conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//            echo "Connected successfully";
            return $conn;
        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
    }

}

