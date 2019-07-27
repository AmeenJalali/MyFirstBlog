<?php

namespace src\models;

use src\services\database\Mysqli;

class CommentModel {

    public function newComment($author, $email, $comment, $postID) {
//        $date = date('Y-m-d H:i:s');
//        $sql = "insert into comments (comment_author_name, comment_author_email, comment_description, comment_published_date, post_id) values ('$author', '$email', '$comment', '$date', '$postID')";
//        run_sql($sql);


        $date = date('Y-m-d H:i:s');

        $data = [
            'comment_author_name' => $author,
            'comment_author_email' => $email,
            'comment_description' => $comment,
            'comment_published_date' => $date,
            'post_id' => $postID
        ];

        Mysqli::insert('comments', $data);

    }

    public function deleteCommentById($commentID) {
//        $sql = "delete from comments where id=$commentID";
//        run_sql($sql);
        Mysqli::delete('comments', $commentID);
    }

}