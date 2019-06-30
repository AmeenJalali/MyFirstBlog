<?php

require_once 'include/config.php';

function validate($input) {
    return trim(htmlspecialchars($input));
}


class Uninstall extends Controller {
    public function index() {
        $installation = $this->model('InstallationModel');

        if ($installation->installed() && file_exists('uninstall.php')) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $installation->removal();
                    $_SESSION = array();
                    session_destroy();
                    rename('uninstall.php', 'install.php');
                    header("location: " . ROOT);
                    exit;
            }
            $title = "Blog Removal";
        } else {
            header("Location: " . ROOT);
            exit;
        }

        $this->view('installation/uninstall', ['errors' => '', 'title' => $title]);
    }

}