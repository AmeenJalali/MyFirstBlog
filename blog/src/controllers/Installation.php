<?php
namespace src\controllers;
use src\core\Controller;

class Installation extends Controller {
    public function index() {
        $installation = $this->model('InstallationModel');
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
                            $installation->create_database();
                            $installation->create_tables();
                            $installation->set_blog_name($blog_name);
                            $installation->create_admin($admin_username, $admin_email, $admin_password);

                            rename('install.php', 'uninstall.php');
                            header("location: " . ROOT . "admin");
                            exit;
                        } else {
                            $error .= 'Installation faild' . "<br>";
                        }
                    }
                }
        $title = "Blog Installation";
        } else {
            header("Location: " . ROOT);
            exit;
        }

        $this->view('installation/index', ['errors' => $error, 'title' => $title]);
    }

}


function validate($input) {
    return trim(htmlspecialchars($input));
}
