<?php


    /////////// Database //////////
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'blog');
    define('DB_USER', 'blog');
    define('DB_PASS', 'Blog()123');
    ///////////////////////////////


    date_default_timezone_set('Asia/Tehran');
    ini_set('display_errors', 'On');

    $config = [
        'ROOT' => "http://localhost/blog",
        'ADMIN_PATH' => "http://localhost/blog/admin",
        'ADMIN_LOGIN_PATH' => "http://localhost/blog/admin/login",
        'ASSETS_PATH' => "http://localhost/blog/assets",
        'BLOG_NAME' => get_blog_name()
    ];

    define('CONFIG', $config);

    function get_blog_name() {
        if (file_exists('uninstall.php')) {
            $sql = "select blog_name from settings where id=1;";
            $data = \src\services\database\MySQLi::execute($sql);
            return $data[0]["blog_name"];
        } else {
            return "Your blog name";
        }
    }
