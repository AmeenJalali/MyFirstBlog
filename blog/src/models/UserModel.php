<?php
namespace src\models;
class UserModel {

    public function check_username_and_password($username, $password): bool {
        $sql = "select user_name, user_password from users where user_id=1";
        $informations = run_sql_with_return($sql);
        if ($informations[0]['user_name'] == $username) {
            if (password_verify($password, $informations[0]['user_password'])) {
                return true;
            }
        }
        return false;
    }
}