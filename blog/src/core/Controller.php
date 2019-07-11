<?php

namespace src\core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Controller {

    var $twig;

    public function __construct() {
        $this->twig = $this->loadTwig();
        $this->twig->addGlobal('SESSION', $_SESSION);
        $this->twig->addGlobal('CONFIG', CONFIG);
    }

    public function twigRender($templateName, $data = []) {
        $fileName = $templateName . ".html.twig";
        echo $this->twig->render($fileName, $data);
    }

    private function loadTwig() {
        $twig_loader = new FilesystemLoader('templates');
        return new Environment($twig_loader);
    }
}