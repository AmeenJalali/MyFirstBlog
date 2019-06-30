<?php


class Controller
{
    public function model($model) {
        require_once 'blog/models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = []) {
        require_once 'blog/views/' . $view . '.php';
    }
}