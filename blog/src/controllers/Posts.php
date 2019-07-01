<?php
namespace src\controllers;
use src\core\Controller;

session_start();

class Posts extends Controller {

    public function index() {
        header("location: " . ROOT);
        exit;
    }

    public function viewpost($postID) {
        $posts = $this->model('PostModel');
        $post = $posts->get_post_by_id($postID);

        $comment = $this->model('CommentModel');

        $errors = "";
        $success = "";

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
                    $comment->new_comment($name, $email, $description, $postID);
                    $success .= "Your comment sent successfully! <br>";
                } else {
                    $errors .= "An error occurred, please try again <br>";
                }

            }
        }

        $comments = $comment->get_all_comments_by_post_id($postID);

        $title = $post[0]['post_title'] . " | " . BLOG_NAME;

        $this->view('posts/index', ['title' => $title, 'post' => $post, 'comments' => $comments, 'errors' => $errors, 'success' => $success]);
    }

    public function deleteComment($commentID = '-1') {
        if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] == false) {
            header("location: " . ADMIN_PATH . "login");
            exit;
        }
        if ($commentID != -1) {
            $comments = $this->model('CommentModel');
            $comments->delete_comment_by_id($commentID);
        }
    }


}

