<?php

namespace src\views;

use src\services\database\Mysqli;
use src\services\database\MysqliQueryBuilder;

class PostView
{
    public function getAllPosts() {
        $queryBuilder = new MysqliQueryBuilder;
        $sql = $queryBuilder->select()
            ->all()
            ->from('posts')
            ->orderBy('post_published_date', 'DESC')
            ->getSQL();
        return Mysqli::execute($sql);

//        $sql = "select * from posts order by post_published_date desc;";
//        return run_sql_with_return($sql);
    }

    public function getPostById($postID) {
//        $sql = "select * from posts where id=$postID";
//        return run_sql_with_return($sql);

        $queryBuilder = new MysqliQueryBuilder;
        $sql = $queryBuilder->select()
            ->all()
            ->from('posts')
            ->where("id=$postID")
            ->getSQL();
        return Mysqli::execute($sql);
    }
}