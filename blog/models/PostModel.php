<?php


class PostModel {

    public function new_post($title, $description) {
        $date = date('Y-m-d H:i:s');
        $sql = "insert into posts (post_title, post_description, post_published_date) values ('$title', '$description', '$date')";
        run_sql($sql);
    }

    public function edit_post($postID, $title, $description) {
        $date = date('Y-m-d H:i:s');
        $sql = "update posts set post_title='$title', post_description='$description', post_published_date='$date' where post_id=$postID";
        run_sql($sql);
    }

    public function get_all_posts() {
        $sql = "select * from posts order by post_published_date desc;";
        return run_sql_with_return($sql);
    }

    public function get_post_by_id($postID) {
        $sql = "select * from posts where post_id=$postID";
        return run_sql_with_return($sql);
    }

    public function delete_post_by_id($postID) {
        $sql = "delete from posts where post_id=$postID";
        run_sql($sql);
        $sql = "delete from comments where post_id=$postID";
        run_sql($sql);
    }

}