<?php

namespace src\core;

class Routing
{

    protected $controller;
    protected $method;
    protected $params;

    public function __construct() {
        $this->controller = 'home';
        $this->method = 'index';
        $this->params = [];
    }

    public function route() : void {
        if (file_exists('install.php')) {
            $this->switchToInstallationController();
            exit;
        } else {
            $url = $this->parseUrl();
            if (isset($url)) {
                $url = $this->checkAndSetIfControllerExists($url);
                $this->initController();
                $url = $this->checkAndSetMethods($url);
                $this->checkAndSetParameters($url);
            } else {
                $this->initController();
            }
            call_user_func_array([$this->controller, $this->method], $this->params);
        }
    }

    private function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }

    private function switchToInstallationController(): void {
        $this->controller = 'installation';
        $this->method = 'index';
        $this->initController();
        call_user_func_array([$this->controller, $this->method], $this->params);
    }


    private function checkAndSetIfControllerExists(array $url) : array {
        if (file_exists("blog/src/controllers/$url[0].php")) {
            $this->controller = $url[0];
            unset($url[0]);
        }
        return $url;
    }

    private function initController() {
        $controller = "src\controllers\\" . $this->controller;
        $this->controller = new $controller;
    }


    private function checkAndSetMethods(array $url) : array {
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }
        return $url;
    }

    private function checkAndSetParameters(array $url) : void {
        $this->params = $url ? array_values($url) : [];
    }
}