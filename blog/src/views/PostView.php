<?php

namespace src\views;

use src\services\database\MySQLi;
use src\services\database\MySQLiQueryBuilder;

class PostView
{
    public function getAllPosts() {
        $queryBuilder = new MySQLiQueryBuilder;
        $sql = $queryBuilder->select()
            ->all()
            ->from('posts')
            ->orderBy('post_published_date', 'DESC')
            ->getSQL();
        return MySQLi::execute($sql);
    }

    public function getPostById($postID) {
        $queryBuilder = new MySQLiQueryBuilder;
        $sql = $queryBuilder->select()
            ->all()
            ->from('posts')
            ->where("id=$postID")
            ->getSQL();
        return MySQLi::execute($sql);
    }
}