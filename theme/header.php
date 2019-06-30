<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="<?php echo THEME_ROOT; ?>css/style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/1e335c4752.js"></script>
    </head>
    <body>


    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="<?php echo ROOT; ?>"><?php echo BLOG_NAME ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                <?php
                if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
                    echo "<li class=\"nav-item\">";
                    echo "<a class=\"nav-link\" href=\"" . ADMIN_PATH . "\">Administrator <span class=\"sr-only\"></span></a>";
                    echo "</li>";

                    echo "<li class=\"nav-item\">";
                    echo "<a class=\"nav-link\" href=\"" . ADMIN_PATH. "logout" . "\">Logout <span class=\"sr-only\"></span></a>";
                    echo "</li>";
                } else {
                    echo "<li class=\"nav-item\">";
                    echo "<a class=\"nav-link\" href=\"" . ADMIN_PATH. "login" . "\">Login <span class=\"sr-only\"></span></a>";
                    echo "</li>";
                }
                ?>

            </ul>

        </div>
    </nav>