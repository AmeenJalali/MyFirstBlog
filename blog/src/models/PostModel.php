<?php

namespace src\models;

class PostModel {

    public function newPost($title, $description) {
        $date = date('Y-m-d H:i:s');
        $sql = "insert into posts (post_title, post_description, post_published_date) values ('$title', '$description', '$date')";
        run_sql($sql);
    }

    public function editPost($postID, $title, $description) {
        $date = date('Y-m-d H:i:s');
        $sql = "update posts set post_title='$title', post_description='$description', post_published_date='$date' where post_id=$postID";
        run_sql($sql);
    }

    public function deletePostById($postID) {
        $sql = "delete from posts where post_id=$postID";
        run_sql($sql);
        $sql = "delete from comments where post_id=$postID";
        run_sql($sql);
    }

}