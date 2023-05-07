<?php

namespace Src\Repository;

use Core\DBManager\DatabaseManager;

class SessionRepository
{
    public static function setTicket(int $row, int $place, int $session_id) {
        $dbm = DatabaseManager::getInstance();
        $dbm->connection->query("INSERT into ticket(ticket_row, ticket_place, session_id)
            values('{$row}', '{$place}', '{$session_id}')");
    }
}