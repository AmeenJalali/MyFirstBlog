<?php
namespace src\controllers;

use src\core\Controller;
use src\models\CommentModel;
use src\models\PostModel;
use src\models\UserModel;

session_start();

class Admin extends Controller {

    public function index() {
        if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] == false) {
            header("location: " . ADMIN_PATH . "login");
            exit;
        }

        $post = new PostModel();
        $posts = $post->get_all_posts();

        $comment = new CommentModel();
        $comments = $comment->get_all_comments();


        $title = 'Administrator panel';
        $this->view('admin/index', ['title' => $title, 'posts' => $posts, 'comments' => $comments]);
    }

    public function newpost() {
        if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] == false) {
            header("location: " . ADMIN_PATH . "login");
            exit;
        }

        $errors = "";
        $success = "";

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            if (isset($_POST['publish'])) {
                $post = new PostModel();
                if(htmlspecialchars($_POST['post_description']) == "") {
                    $errors .= "Description can't be empty <br>";
                }
                if(htmlspecialchars($_POST['post_title']) == "") {
                    $errors .= "Post title is required <br>";
                }

                if ($errors == "") {
                    $description = htmlspecialchars($_POST['post_description']);
                    $title = htmlspecialchars($_POST['post_title']);
                    $post->new_post($title, $description);
                    $success .= "The post added successfully! <br>";
                    header( "refresh:1 ; url=" . ADMIN_PATH );
                } else {
                    $errors .= "An error occurred, please try again <br>";
                }

            }
        }

        $title = 'New post';
        $this->view('admin/newPost', ['title' => $title, 'errors' => $errors, 'success' => $success]);
    }

    public function deletePost($postID = '-1') {
        if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] == false) {
            header("location: " . ADMIN_PATH . "login");
            exit;
        }
        if ($postID != -1) {
            $posts = new PostModel();
            $posts->delete_post_by_id($postID);
        }
        header("location: " . ADMIN_PATH);
        exit;
    }

    public function editPost($postID = '-1') {
        if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] == false) {
            header("location: " . ADMIN_PATH . "login");
            exit;
        }
        if ($postID != -1) {
            $posts = new PostModel();
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
                        $posts->edit_post($postID, $title, $description);
                        $success .= "The post edited successfully! <br>";
                        header( "refresh:1 ; url=" . ADMIN_PATH );
                    } else {
                        $errors .= "An error occurred, please try again <br>";
                    }

                }
            }

            $post = $posts->get_post_by_id($postID);
            $title = 'Edit post';
            $this->view('admin/editPost', ['title' => $title, 'post' => $post, 'errors' => $errors, 'success' => $success]);

        } else {
            header("location: " . ADMIN_PATH);
            exit;
        }
    }

    public function logout() {
        $_SESSION = array();
        session_destroy();
        header("location: " . ADMIN_PATH);
        exit;
    }

    public function login() {
        if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
            header("location: " . ADMIN_PATH);
            exit;
        }
        $errors = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['login'])) {

                $username = validate($_POST["admin_username"]);
                $password = validate($_POST["admin_password"]);

                $admin = new UserModel();
                $is_valid = $admin->check_username_and_password($username, $password);

                if($is_valid) {
                    $_SESSION["logged_in"] = true;
                    $_SESSION["username"] = $username;
                    header("location: " . ADMIN_PATH);
                    exit;

                } else {
                    $errors .= "Username or password is incorrect.";
                }
            }
        }
        $title = 'Log in to administrator';
        $this->view('admin/login', ['title' => $title, 'errors' => $errors]);
    }
}

function validate($input) {
    return trim(htmlspecialchars($input));
}