<?php

namespace src\models;

class InstallationModel {

    public function createDatabase() {
        $sql = 'create database if not exists blog;';
        run_sql($sql);
    }

    public function createTables() {
        create_settings_table();
        create_users_table();
        create_posts_table();
        create_comments_table();
    }

    public function createAdmin($username, $email, $password) {
        $sql = 'insert into users (user_name, user_email, user_password) '.
            "values ('$username', '$email', '$password');";
        run_sql($sql);
    }

    public function setBlogName($blog_name) {
        $sql = "insert into settings (blog_name) values ('$blog_name')";
        run_sql($sql);
    }

    public function installed(): bool {
        $sql = 'select count(*) from settings where blog_id=1;';
        return sql_count($sql) != 0;
    }

    public function removal() {
        $sql = "drop table if exists settings, posts, users, comments;";
        run_sql($sql);
    }
}

function create_settings_table() {
    $sql = 'create table if not exists settings ('.
        'blog_id int not null auto_increment,'.
        'blog_name varchar(255) not null,'.
        'primary key (blog_id));';
    run_sql($sql);
}

function create_users_table() {
    $sql = 'create table if not exists users (' .
        'user_id int not null auto_increment,' .
        'user_name varchar(255) not null,' .
        'user_email varchar(255) not null,' .
        'user_password varchar(255) not null,' .
        'primary key (user_id));';
    run_sql($sql);
}

function create_posts_table() {
    $sql = 'create table if not exists posts (' .
        'post_id int not null auto_increment,' .
        'post_title varchar(255) not null,' .
        'post_description text not null,' .
        'post_published_date datetime not null,' .
        'primary key (post_id));';
    run_sql($sql);
}

function create_comments_table() {
    $sql = 'create table if not exists comments (' .
        'comment_id int not null auto_increment,' .
        'comment_author_name varchar(255) not null,' .
        'comment_author_email varchar(255) not null,' .
        'comment_published_date datetime not null,' .
        'comment_description text not null,' .
        'post_id int not null,' .
        'primary key (comment_id));';
    run_sql($sql);
}