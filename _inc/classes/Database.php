<?php

class Database {
    private $host = 'localhost';
    private $dbname = 'electro';
    private $username = 'root';
    private $password = '';

    private $connection;

    public function __destruct() {
        $this->connection = null;
    }

    public function db_connection() {
        try {
            $this->connection = new PDO(
                'mysql:host='.$this->host.';dbname='.$this->dbname.';charset=utf8',
                $this->username,
                $this->password
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

            return $this->connection;
        } catch (PDOException $e) {
            return 0;
            die ('Database connection error: ' .$e->getMessage());
        }
    }
}

?>