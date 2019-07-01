<?php
namespace src\core;

class Controller
{
    public function model($model) {
        $className = "src\models\\" . $model;
        return new $className;
    }

    public function view($view, $data = []) {
        require_once 'blog/src/views/' . $view . '.php';
    }
}