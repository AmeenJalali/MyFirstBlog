<?php
namespace src\controllers;

use src\core\Controller;
use src\models\PostModel;
use src\models\UserModel;
use src\views\CommentView;
use src\views\PostView;

session_start();

class Admin extends Controller {

    public function index() {
        if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] == false) {
            header("location: " . CONFIG['ADMIN_LOGIN_PATH']);
            exit;
        }

        $postView = new PostView();
        $commentView = new CommentView();

        $posts = $postView->get_all_posts();
        $comments = $commentView->get_all_comments();

        $this->twig_render('admin/index', ['posts' => $posts, 'comments' => $comments]);
    }

    public function newpost() {
        if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] == false) {
            header("location: " . CONFIG['ADMIN_LOGIN_PATH']);
            exit;
        }

        $errors = "";
        $success = "";

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            if (isset($_POST['publish'])) {
                $postModel = new PostModel();
                if(htmlspecialchars($_POST['post_description']) == "") {
                    $errors .= "Description can't be empty <br>";
                }
                if(htmlspecialchars($_POST['post_title']) == "") {
                    $errors .= "Post title is required <br>";
                }

                if ($errors == "") {
                    $description = htmlspecialchars($_POST['post_description']);
                    $title = htmlspecialchars($_POST['post_title']);
                    $postModel->new_post($title, $description);
                    $success .= "The post added successfully! <br>";
                    header( "refresh:1 ; url=" . CONFIG['ADMIN_PATH'] );
                } else {
                    $errors .= "An error occurred, please try again <br>";
                }

            }
        }

        $this->twig_render('admin/new_post', ['errors' => $errors, 'success' => $success]);
    }

    public function deletePost($postID = '-1') {
        if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] == false) {
            header("location: " . CONFIG['ADMIN_LOGIN_PATH']);
            exit;
        }
        if ($postID != -1) {
            $postModel = new PostModel();
            $postModel->delete_post_by_id($postID);
        }
        header("location: " . CONFIG['ADMIN_PATH']);
        exit;
    }

    public function editPost($postID = '-1') {
        if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] == false) {
            header("location: " . CONFIG['ADMIN_LOGIN_PATH']);
            exit;
        }
        if ($postID != -1) {
            $postModel = new PostModel();
            $postView = new PostView();
            $errors = "";
            $success = "";

            if ($_SERVER["REQUEST_METHOD"] === 'POST') {
                if (isset($_POST['saveChanges'])) {
                    if(htmlspecialchars($_POST['post_description']) == "") {
                        $errors .= "Description can't be empty <br>";
                    }
                    if(htmlspecialchars($_POST['post_title']) == "") {
                        $errors .= "Post title is required <br>";
                    }

                    if ($errors == "") {
                        $description = htmlspecialchars($_POST['post_description']);
                        $title = htmlspecialchars($_POST['post_title']);
                        $postModel->edit_post($postID, $title, $description);
                        $success .= "The post edited successfully! <br>";
                        header( "refresh:1 ; url=" . CONFIG['ADMIN_PATH'] );
                    } else {
                        $errors .= "An error occurred, please try again <br>";
                    }

                }
            }

            $post = $postView->get_post_by_id($postID);
            $post = $post[0];
            $this->twig_render('admin/edit_post', ['post' => $post, 'errors' => $errors, 'success' => $success]);

        } else {
            header("location: " . CONFIG['ADMIN_PATH']);
            exit;
        }
    }

    public function logout() {
        $_SESSION = array();
        session_destroy();
        header("location: " . CONFIG['ADMIN_PATH']);
        exit;
    }

    public function login() {
        if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
            header("location: " . CONFIG['ADMIN_LOGIN_PATH']);
            exit;
        }
        $errors = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['login'])) {

                $username = validate($_POST["admin_username"]);
                $password = validate($_POST["admin_password"]);

                $userModel = new UserModel();
                $is_valid = $userModel->user_is_valid($username, $password);

                if($is_valid) {
                    $_SESSION["logged_in"] = true;
                    $_SESSION["username"] = $username;
                    header("location: " . CONFIG['ADMIN_PATH']);
                    exit;

                } else {
                    $errors .= "Username or password is incorrect.";
                }
            }
        }
        $this->twig_render('admin/login', ['errors' => $errors]);
    }
}

function validate($input) {
    return trim(htmlspecialchars($input));
}