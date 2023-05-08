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
            WHERE m.movie_id={$mid} and s.session_time>'" . date('Y-m-d H:i:s') . "'")
        ->fetch_all();
        return $sessions;
    }

    public static function getSessionById(int $id) {
        $dbm = DatabaseManager::getInstance();
        $sessions = $dbm->connection->query("
            SELECT *
            FROM session
            WHERE session_id={$id}")
        ->fetch_assoc();
        $sessions['session_schema'] = json_decode($sessions['session_schema']);
        return $sessions;
    }

    public static function updateSessionSchema(int $sid, string $json_schema) {
        $dbm = DatabaseManager::getInstance();
        $dbm->connection->query("UPDATE session SET session_schema='{$json_schema}' WHERE session_id='{$sid}'");
    }
}