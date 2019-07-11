<?php

namespace src\models;

class UserModel {

    public function userIsValid($username, $password): bool {
        $sql = "select user_name, user_password from users where user_id=1";
        $userInformation = run_sql_with_return($sql);
        if ($userInformation[0]['user_name'] == $username) {
            if (password_verify($password, $userInformation[0]['user_password'])) {
                return true;
            }
        }
        return false;
    }
}