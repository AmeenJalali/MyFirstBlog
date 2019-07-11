<?php

namespace src\controllers;

use src\core\Controller;
use src\models\CommentModel;
use src\views\CommentView;
use src\views\PostView;

session_start();

class Posts extends Controller {

    public function index() {
        header("location: " . CONFIG['ROOT']);
        exit;
    }

    public function viewPost($postID = -1) {

        $postView = new PostView();
        $commentModel = new CommentModel();
        $commentView = new CommentView();
        $post = $postView->getPostById($postID);
        $errors = "";
        $success = "";


        if (sizeof($post) == 0) {
            // TODO -> 404 error
           header("location: " . CONFIG['ROOT']);
           exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            if (isset($_POST['send'])) {


                if(htmlspecialchars($_POST['comment_author']) == "") {
                    $errors .= "Name can't be empty <br>";
                }

                if (!filter_var($_POST['comment_email'], FILTER_VALIDATE_EMAIL)) {
                    $errors .= 'Invalid Email' . "<br>";
                }

                if ($_POST['comment_email'] == "") {
                    $errors .= 'Email can\'t be empty' . "<br>";
                }

                if(htmlspecialchars($_POST['comment_description']) == "") {
                    $errors .= "Your comment is empty! <br>";
                }

                if ($errors == "") {
                    $description = htmlspecialchars($_POST['comment_description']);
                    $name = htmlspecialchars($_POST['comment_author']);
                    $email = htmlspecialchars($_POST['comment_email']);
                    $commentModel->newComment($name, $email, $description, $postID);
                    $success .= "Your comment sent successfully! <br>";
                } else {
                    $errors .= "An error occurred, please try again <br>";
                }

            }
        }

        $comments = $commentView->getAllCommentsByPostId($postID);

        $post = $post[0];

        $this->twigRender('posts/index', ['post' => $post, 'comments' => $comments, 'errors' => $errors, 'success' => $success]);
    }


    public function deleteComment($commentID = '-1') {
        if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] == false) {
            header("location: " . CONFIG['ADMIN_LOGIN_PATH']);
            exit;
        }
        if ($commentID != -1) {
            $commentModel = new CommentModel();
            $commentModel->deleteCommentById($commentID);
        }
    }


}

