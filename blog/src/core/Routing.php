<?php
namespace src\core;

class Routing
{

    protected $controller = 'home';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {

        if (file_exists('install.php')) {
            $this->controller = 'installation';
            $this->method = 'index';
            $className = "src\controllers\\" . $this->controller;
            $this->controller = new $className;
            call_user_func_array([$this->controller, $this->method], $this->params);
            exit;
        }

        $url = $this->parseUrl();

        if (file_exists("blog/src/controllers/$url[0].php")) {
            $this->controller = $url[0];
            unset($url[0]);
        }

        $className = "src\controllers\\" . $this->controller;
        $this->controller = new $className;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    protected function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}