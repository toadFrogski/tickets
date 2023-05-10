<?php

namespace Src\Repository;

use Core\DBManager\DatabaseManager;

class SessionRepository
{
    public static function getAllAvaiableMovieSessions(int $mid) {
        $dbm = DatabaseManager::getInstance();
        $all_sessions = $dbm->connection->query("
            SELECT s.session_id, s.session_time, c.cinema_name, c.cinema_id            
            FROM session s
            INNER JOIN movie m ON m.movie_id=s.movie_id
            INNER JOIN cinemahall ch ON ch.cinemahall_id=s.cinemahall_id
            INNER JOIN cinema c ON c.cinema_id=ch.cinema_id
            WHERE m.movie_id={$mid} and s.session_time>'" . date('Y-m-d H:i:s') . "'")
            ->fetch_all();

        $sessions = [];
        foreach($all_sessions as $session) {
            $sessions[$session[2]][] = [$session[0], $session[1], $session[3]];
        }

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