<?php

namespace Src\Repository;

use Core\DBManager\DatabaseManager;

class SessionRepository
{
    public static function getAllAvaiableMovieSessions(int $mid) {
        $dbm = DatabaseManager::getInstance();
        $sessions = $dbm->connection->query("
            SELECT s.*
            FROM session s
            INNER JOIN movie m ON m.movie_id=s.movie_id 
            WHERE m.movie_id={$mid}")->fetch_all();
        return $sessions;
    }
}