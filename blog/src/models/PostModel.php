<?php

namespace src\models;

use src\services\database\Mysqli;
use src\services\database\MysqliQueryBuilder;

class PostModel {

    public function newPost($title, $description) {
        $date = date('Y-m-d H:i:s');

        $data = [
          'post_title' => $title,
          'post_description' => $description,
          'post_published_date' => $date
        ];

        Mysqli::insert('posts', $data);

//        $sql = "insert into posts (post_title, post_description, post_published_date) values ('$title', '$description', '$date')";
//        run_sql($sql);
    }

    public function editPost($postID, $title, $description) {
        $date = date('Y-m-d H:i:s');
//        $sql = "update posts set post_title='$title', post_description='$description', post_published_date='$date' where id=$postID";
//        run_sql($sql);

        $data = [
          'post_title' => $title,
          'post_description' => $description,
          'post_published_date' => $date
        ];

        Mysqli::update('posts', $postID, $data);

    }

    public function deletePostById($postID) {

        Mysqli::delete('posts', $postID);

        $queryBuilder = new MysqliQueryBuilder;
        $sql = $queryBuilder->delete('comments')
            ->where(
                [
                    'post_id' => $postID
                ]
            )
            ->getSQL();

        Mysqli::execute($sql);

//        $sql = "delete from posts where id=$postID";
//        run_sql($sql);
//        $sql = "delete from comments where post_id=$postID";
//        run_sql($sql);
    }

}