<?php

namespace src\views;

use src\services\database\MySQLi;
use src\services\database\MySQLiQueryBuilder;

class CommentView
{
    public function getAllCommentsByPostId($postID) {
        $queryBuilder = new MySQLiQueryBuilder;
        $sql = $queryBuilder->select()
            ->all()
            ->from('comments')
            ->where("post_id=$postID")
            ->orderBy('comment_published_date', 'DESC')
            ->getSQL();
        return MySQLi::execute($sql);
    }

    public function getAllComments() {

        $queryBuilder = new MySQLiQueryBuilder;
        $sql = $queryBuilder->select()
            ->all()
            ->from('comments')
            ->orderBy('comment_published_date', 'DESC')
            ->getSQL();
        return MySQLi::execute($sql);
    }
}