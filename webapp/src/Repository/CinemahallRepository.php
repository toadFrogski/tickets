<?php

namespace Src\Repository;

use Core\DBManager\DatabaseManager;

class CinemahallRepository
{

    public static function getAllCinemahalls()
    {
        $dbm = DatabaseManager::getInstance();
        $cinemahalls = $dbm->connection->query("SELECT * from cinemahall")->fetch_all();
        $cinemahalls = array_map(function ($hall) {
            $hall[1] = json_decode($hall[1]);
            return $hall; }, $cinemahalls);
        return $cinemahalls;
    }
}