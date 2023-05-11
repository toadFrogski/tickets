<?php

namespace Src\Repository;

use Core\DBManager\DatabaseManager;

class ManagerRepository
{
    public static function newManager($email, $password) {
        $dbm = DatabaseManager::getInstance();
        return $dbm->connection->query("insert into manager(manager_email, manager_password) values('{$email}', '{$password}')");
    }
    public static function getAllManagers()
    {
        $dbm = DatabaseManager::getInstance();
        return $dbm->connection->query("SELECT manager_email, manager_password, manager_id FROM manager")->fetch_all();
    }
    public static function getManagerById($id) {
         $dbm = DatabaseManager::getInstance();
         return $dbm->connection->query("select * from manager where manager_id = '{$id}'")->fetch_assoc();
    }

    public static function updateManager($id, $email, $password)
    {
        $dbm = DatabaseManager::getInstance();
        return $dbm->connection->query("update manager set manager_email='{$email}', manager_password='{$password}' where manager_id = '{$id}'");
    }
}