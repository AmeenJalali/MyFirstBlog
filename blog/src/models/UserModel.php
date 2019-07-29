<?php

namespace src\models;

use src\services\database\MySQLi;
use src\services\database\MySQLiQueryBuilder;

class UserModel {

    public function userIsValid($username, $password): bool {
        $queryBuilder = new MySQLiQueryBuilder;
        $sql = $queryBuilder->select('user_name', 'user_password')
            ->from('users')
            ->where('id=1')
            ->getSQL();
        $userInformation = MySQLi::execute($sql);
        if ($userInformation[0]['user_name'] == $username) {
            if (password_verify($password, $userInformation[0]['user_password'])) {
                return true;
            }
        }
        return false;
    }
}