<?php
namespace src\controllers;
use src\core\Controller;
use src\models\PostModel;

session_start();

class Home extends Controller
{
    public function index() {
            $post = new PostModel();
            $posts = $post->get_all_posts();
            $title = 'Home Page | Blogger';
            $this->view('home/index', ['title' => $title, 'posts' => $posts]);
    }

}