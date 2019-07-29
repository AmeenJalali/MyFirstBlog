<?php

namespace src\models;

use src\services\database\MySQLi;

class CommentModel {

    public function newComment($author, $email, $comment, $postID) {
        $date = date('Y-m-d H:i:s');
        $data = [
            'comment_author_name' => $author,
            'comment_author_email' => $email,
            'comment_description' => $comment,
            'comment_published_date' => $date,
            'post_id' => $postID
        ];

        MySQLi::insert('comments', $data);
    }

    public function deleteCommentById($commentID) {
        MySQLi::delete('comments', $commentID);
    }

}