<?php

namespace src\models;

use src\services\database\Mysqli;
use src\services\database\MysqliQueryBuilder;

class UserModel {

    public function userIsValid($username, $password): bool {
//        $sql = "select user_name, user_password from users where id=1";
        $queryBuilder = new MysqliQueryBuilder;
        $sql = $queryBuilder->select('user_name', 'user_password')
            ->from('users')
            ->where('id=1')
            ->getSQL();
        $userInformation = Mysqli::execute($sql);
        if ($userInformation[0]['user_name'] == $username) {
            if (password_verify($password, $userInformation[0]['user_password'])) {
                return true;
            }
        }
        return false;
    }
}