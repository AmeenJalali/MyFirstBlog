<?php
namespace src\controllers;
use src\core\Controller;
use src\models\PostModel;
use src\views\PostView;

session_start();

class Home extends Controller
{
    public function index() {
            $postView = new PostView();
            $posts = $postView->get_all_posts();
            $this->twig_render('home/index', ['posts' => $posts]);
    }

}