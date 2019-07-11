<?php

namespace src\views;

class PostView
{
    public function getAllPosts() {
        $sql = "select * from posts order by post_published_date desc;";
        return run_sql_with_return($sql);
    }

    public function getPostById($postID) {
        $sql = "select * from posts where post_id=$postID";
        return run_sql_with_return($sql);
    }
}