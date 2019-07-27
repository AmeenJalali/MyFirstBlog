<?php

namespace src\views;

use src\services\database\Mysqli;
use src\services\database\MysqliQueryBuilder;

class CommentView
{
    public function getAllCommentsByPostId($postID) {
//        $sql = "select * from comments where post_id=$postID order by comment_published_date desc;";
        $queryBuilder = new MysqliQueryBuilder;
        $sql = $queryBuilder->select()
            ->all()
            ->from('comments')
            ->where("post_id=$postID")
            ->orderBy('comment_published_date', 'DESC')
            ->getSQL();
        return Mysqli::execute($sql);
//        return run_sql_with_return($sql);
    }

    public function getAllComments() {

        $queryBuilder = new MysqliQueryBuilder;
        $sql = $queryBuilder->select()
            ->all()
            ->from('comments')
            ->orderBy('comment_published_date', 'DESC')
            ->getSQL();
        return Mysqli::execute($sql);

//        $sql = "select * from comments order by comment_published_date desc;";
//        return run_sql_with_return($sql);
    }
}