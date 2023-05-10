<?php

namespace Src\Repository;

use Core\DBManager\DatabaseManager;

class ManagerRepository
{
    public static function getAllManagers()
    {
        $dbm = DatabaseManager::getInstance();
        return $dbm->connection->query("SELECT * FROM manager");
    }
}