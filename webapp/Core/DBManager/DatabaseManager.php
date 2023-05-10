<?php

namespace Core\DBManager;

use mysqli;

class DatabaseManager
{
    private static array $instances = [];
    public mysqli|bool $connection;
    private string $host;
    private string $dbname;
    private string $username;
    private string $password;
    private function __construct($host, $dbname, $username, $password)
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
        $this->connect();
    }
    public static function getInstance(): DatabaseManager
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            global $database_settings;
            self::$instances[$cls] = new static($database_settings['host'], $database_settings['database'], $database_settings['username'], $database_settings['password']);
        }

        return self::$instances[$cls];
    }
    private function connect()
    {
        $this->connection = mysqli_connect($this->host, $this->username, $this->password, $this->dbname);
        if (!$this->connection)
            throw new \Exception('Cannot connect to database');
    }

    public function __destruct()
    {
        $this->connection->close();
    }
}