<?php
namespace src\models;

class CommentModel {

    public function new_comment($author, $email, $comment, $postID) {
        $date = date('Y-m-d H:i:s');
        $sql = "insert into comments (comment_author_name, comment_author_email, comment_description, comment_published_date, post_id) values ('$author', '$email', '$comment', '$date', '$postID')";
        run_sql($sql);
    }

    public function get_all_comments_by_post_id($postID) {
        $sql = "select * from comments where post_id=$postID order by comment_published_date desc;";
        return run_sql_with_return($sql);
    }

    public function get_all_comments() {
        $sql = "select * from comments order by comment_published_date desc;";
        return run_sql_with_return($sql);
    }

    public function delete_comment_by_id($commentID) {
        $sql = "delete from comments where comment_id=$commentID";
        run_sql($sql);
    }

}