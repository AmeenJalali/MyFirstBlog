<?php

namespace src\controllers;

use src\core\Controller;
use src\models\InstallationModel;

session_start();

class Installation extends Controller {
    public function index() {
        $installation = new InstallationModel();
        $error = "";

        if (!$installation->installed()) {

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                if (isset($_POST['install'])) {

                        $blog_name = validate($_POST['blog_name']);
                        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $blog_name)) {
                            $error = 'Blog name required and can only contain letters, numbers and white spaces' . "<br>";
                        }
                        $admin_username = validate($_POST['admin_username']);
                        if (!preg_match('/^[0-9A-Za-z!@#$% ]+$/', $admin_username) || preg_match('/^ /', $admin_username) || preg_match('/ $/', $admin_username)) {
                            $error .= 'Username required and can only contain letters, numbers without white spaces' . "<br>";
                        }
                        $admin_email = validate($_POST['admin_email']);
                        if (!filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
                            $error .= 'Invalid Email' . "<br>";
                        }
                        $admin_password = validate($_POST['admin_password']);
                        if (strlen($admin_password) < 6) {
                            $error .= 'Please enter a long password' . "<br>";
                        } else {
                            $admin_password = password_hash($admin_password, PASSWORD_DEFAULT);
                        }

                        if ($error == "") {
                            $installation->createDatabase();
                            $installation->createTables();
                            $installation->setBlogName($blog_name);
                            $installation->createAdmin($admin_username, $admin_email, $admin_password);

                            rename('install.php', 'uninstall.php');
                            header("location: " .  CONFIG['ADMIN_PATH']);
                            exit;
                        } else {
                            $error .= 'Installation faild' . "<br>";
                        }
                    }
                }
        } else {
            header("Location: " . CONFIG['ROOT']);
            exit;
        }

        $this->twigRender('installation/index', ['errors' => $error]);
    }

}


function validate($input) {
    return trim(htmlspecialchars($input));
}
