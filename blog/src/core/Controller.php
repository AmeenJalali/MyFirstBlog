<?php
namespace src\core;

class Controller
{
    public function view($view, $data = []) {
        require_once 'blog/src/views/' . $view . '.php';
    }
}