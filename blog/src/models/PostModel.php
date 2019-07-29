<?php

namespace src\models;

use src\services\database\MySQLi;
use src\services\database\MySQLiQueryBuilder;

class PostModel {

    public function newPost($title, $description) {
        $date = date('Y-m-d H:i:s');

        $data = [
          'post_title' => $title,
          'post_description' => $description,
          'post_published_date' => $date
        ];

        MySQLi::insert('posts', $data);
    }

    public function editPost($postID, $title, $description) {
        $date = date('Y-m-d H:i:s');

        $data = [
          'post_title' => $title,
          'post_description' => $description,
          'post_published_date' => $date
        ];

        MySQLi::update('posts', $postID, $data);

    }

    public function deletePostById($postID) {

        MySQLi::delete('posts', $postID);

        $queryBuilder = new MySQLiQueryBuilder;
        $sql = $queryBuilder->delete('comments')
            ->where(
                [
                    'post_id' => $postID
                ]
            )
            ->getSQL();

        MySQLi::execute($sql);
    }

}