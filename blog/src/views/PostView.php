<?php

namespace src\views;

class PostView
{
    public function get_all_posts() {
        $sql = "select * from posts order by post_published_date desc;";
        return run_sql_with_return($sql);
    }

    public function get_post_by_id($postID) {
        $sql = "select * from posts where post_id=$postID";
        return run_sql_with_return($sql);
    }
}