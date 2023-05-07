<?php

namespace Src\Repository;

use Core\DBManager\DatabaseManager;

class CinemaRepository
{

    public static function getAllCinemas()
    {
        $dbm = DatabaseManager::getInstance();
        return $dbm->connection->query("SELECT * from cinema")->fetch_all();
    }
}