<?php
    require_once 'vendor/autoload.php';

    use src\core\Routing;

    $blog = new Routing();
    $blog->route();