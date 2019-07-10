<?php

namespace src\views;

class CommentView
{
    public function get_all_comments_by_postid($postID) {
        $sql = "select * from comments where post_id=$postID order by comment_published_date desc;";
        return run_sql_with_return($sql);
    }

    public function get_all_comments() {
        $sql = "select * from comments order by comment_published_date desc;";
        return run_sql_with_return($sql);
    }
}