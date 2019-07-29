<?php

namespace src\models;

use src\services\database\MySQLi;
use src\services\database\MySQLiQueryBuilder;

class InstallationModel {

    public function createDatabase() {
        $sql = 'CREATE DATABASE IF NOT EXISTS blog;';
        MySQLi::execute($sql);
    }

    public function createTables() {
        create_settings_table();
        create_users_table();
        create_posts_table();
        create_comments_table();
    }

    public function createAdmin($username, $email, $password) {
        $data = [
          'user_name' => $username,
          'user_email' => $email,
          'user_password' => $password
        ];
        MySQLi::insert('users', $data);
    }

    public function setBlogName($blog_name) {
        $data = [
          'blog_name' => $blog_name
        ];
        MySQLi::insert('settings', $data);
    }

    public function removal() {
        $sql = "drop table if exists settings, posts, users, comments;";
        MySQLi::execute($sql);
    }
}

function create_settings_table() {
    $sql = 'create table if not exists settings ('.
        'id int not null auto_increment,'.
        'blog_name varchar(255) not null,'.
        'primary key (id));';
    MySQLi::execute($sql);
}

function create_users_table() {
    $sql = 'create table if not exists users (' .
        'id int not null auto_increment,' .
        'user_name varchar(255) not null,' .
        'user_email varchar(255) not null,' .
        'user_password varchar(255) not null,' .
        'primary key (id));';
    MySQLi::execute($sql);
}

function create_posts_table() {
    $sql = 'create table if not exists posts (' .
        'id int not null auto_increment,' .
        'post_title varchar(255) not null,' .
        'post_description text not null,' .
        'post_published_date datetime not null,' .
        'primary key (id));';
    MySQLi::execute($sql);
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
    MySQLi::execute($sql);
}