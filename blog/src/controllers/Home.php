<?php

namespace src\controllers;

use src\core\Controller;
use src\views\PostView;

session_start();

class Home extends Controller
{
    public function index() {
            $postView = new PostView();
            $posts = $postView->getAllPosts();
            $this->twigRender('home/index', ['posts' => $posts]);
    }

}