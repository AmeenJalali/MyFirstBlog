<?php
namespace src\controllers;
use src\core\Controller;
use src\models\InstallationModel;

session_start();

class Uninstall extends Controller {
    public function index() {
        $installation = new InstallationModel();

        if ($installation->installed() && file_exists('uninstall.php')) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $installation->removal();
                    $_SESSION = array();
                    session_destroy();
                    rename('uninstall.php', 'install.php');
                    header("location: " . CONFIG['ROOT']);
                    exit;
            }
            $title = "Blog Removal";
        } else {
            header("Location: " . CONFIG['ROOT']);
            exit;
        }

        $this->view('installation/uninstall', ['errors' => '', 'title' => $title]);
    }

}

function validate($input) {
    return trim(htmlspecialchars($input));
}
