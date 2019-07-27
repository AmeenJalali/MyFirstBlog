<?php

namespace src\models;

use src\services\database\Mysqli;

class InstallationModel {

    public function createDatabase() {
        $sql = 'CREATE DATABASE IF NOT EXISTS blog;';
        Mysqli::execute($sql);
//        run_sql($sql);
    }

    public function createTables() {
        create_settings_table();
        create_users_table();
        create_posts_table();
        create_comments_table();
    }

    public function createAdmin($username, $email, $password) {
//        $sql = 'insert into users (user_name, user_email, user_password) '.
//            "values ('$username', '$email', '$password');";
//        run_sql($sql);

        $data = [
          'user_name' => $username,
          'user_email' => $email,
          'user_password' => $password
        ];
        Mysqli::insert('users', $data);

    }

    public function setBlogName($blog_name) {
//        $sql = "insert into settings (blog_name) values ('$blog_name')";
//        run_sql($sql);
        $data = [
          'blog_name' => $blog_name
        ];
        Mysqli::insert('settings', $data);
    }

    public function installed(): bool {
        $sql = 'select count(*) from settings where id=1;';
        return sql_count($sql) != 0;
    }

    public function removal() {
        $sql = "drop table if exists settings, posts, users, comments;";
//        run_sql($sql);
        Mysqli::execute($sql);
    }
}

function create_settings_table() {
    $sql = 'create table if not exists settings ('.
        'id int not null auto_increment,'.
        'blog_name varchar(255) not null,'.
        'primary key (id));';
    Mysqli::execute($sql);
//    run_sql($sql);
}

function create_users_table() {
    $sql = 'create table if not exists users (' .
        'id int not null auto_increment,' .
        'user_name varchar(255) not null,' .
        'user_email varchar(255) not null,' .
        'user_password varchar(255) not null,' .
        'primary key (id));';
    Mysqli::execute($sql);
//    run_sql($sql);
}

function create_posts_table() {
    $sql = 'create table if not exists posts (' .
        'id int not null auto_increment,' .
        'post_title varchar(255) not null,' .
        'post_description text not null,' .
        'post_published_date datetime not null,' .
        'primary key (id));';
//    run_sql($sql);
    Mysqli::execute($sql);
}

function create_comments_table() {
    $sql = 'create table if not exists comments (' .
        'id int not null auto_increment,' .
        'comment_author_name varchar(255) not null,' .
        'comment_author_email varchar(255) not null,' .
        'comment_published_date datetime not null,' .
        'comment_description text not null,' .
        'post_id int not null,' .
        'primary key (id));';
//    run_sql($sql);
    Mysqli::execute($sql);
}