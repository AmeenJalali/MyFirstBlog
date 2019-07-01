<?php
$title = $data['title'];
require 'theme/header.php';
?>

<main>
    <div class="container">

        <h2 class="text-center">Adminstrator panel</h2>
        <h6 class="text-center">Hi, <?php echo $_SESSION["username"] ?>! | <a href="<?php echo ADMIN_PATH . 'logout' ?>">Sign out</a></h6>

            <p class="text-center"><a href="<?php echo ADMIN_PATH . "newPost" ?>"><button class="btn btn-primary btn-md">New Post</button></a>
                <a href="<?php echo ROOT . "uninstall" ?>" class="btn btn-md btn-danger">Uninstall Blog</a>
            </p>

        <div class="row">
            <div class="col-6">
                <h2 class="text-center">Last posts: </h2>

                <?php

                $posts = $data['posts'];

                if (sizeof($posts) == 0) {
                    echo "No posts found";
                } else {
                    for ($i = 0; $i < sizeof($posts); $i++) {
                        echo "<div><a href=\"" . ROOT . "posts/viewpost/" . $posts[$i]['post_id'] . "\"><p><h3>" . $posts[$i]['post_title'] . "</h3></a>" .
                            "<a href=\"editPost/" . $posts[$i]['post_id'] . "\" class=\"btn btn-xs btn-info\">Edit</a>" .
                            "<a href=\"\" data-post-id=\"" . $posts[$i]['post_id'] . "\" class=\"delete-post btn btn-xs btn-danger\">Delete</a>"
                            . "</p>";
                        echo "<p>Post id: " . $posts[$i]['post_id'] . " , Published date: " . $posts[$i]['post_published_date'] . "</p>";
                        echo "<hr></div>";

                    }
                }

                ?>

            </div>


            <div class="col-6">
                <h2 class="text-center">Last comments: </h2>

                <?php
                $comments = $data['comments'];

                if (sizeof($comments) == 0) {
                    echo "No comment found";
                } else {
                    for ($i = 0; $i < sizeof($comments); $i++) {
                        echo "<div>";
                        echo "<p><b>Comment author: </b>" . $comments[$i]['comment_author_name'] . " - " . $comments[$i]['comment_author_email'] . "</p><p>" . "<b>Comment id:</b> " . $comments[$i]['comment_id'] . " - <b>Published date:</b> " . $comments[$i]['comment_published_date'] . "</p>";
                        echo "<p><b>Comment: </b>" . $comments[$i]['comment_description'] . "</p>";
                        echo "<a href=\"\" data-comment-id=\"" . $comments[$i]['comment_id'] . "\" class=\"delete-comment btn btn-xs btn-danger\">Delete</a> <hr></div>";

                    }
                }

                ?>

            </div>
        </div>
    </div>

</main>


<script>
    $(document).ready(function(){
        $('.delete-post').click(function(e){
            e.preventDefault();
            var postid = $(this).attr('data-post-id');
            var parent = $(this).parent("div");
            bootbox.dialog({
                message: "Are you sure you want to delete this post?",
                title: "<i class='glyphicon glyphicon-trash'></i>",
                buttons: {
                    basic: {
                        label: "No",
                        className: "",
                        callback: function() {
                            $('.bootbox').modal('hide');
                        }
                    },
                    danger: {
                        label: "Yes, Delete it!",
                        className: "btn-danger",
                        callback: function() {
                            $.ajax({
                                type: 'POST',
                                url: 'deletePost/' + postid
                            })
                            .done(function(){
                                parent.fadeOut('slow');
                            })
                            .fail(function(){
                                bootbox.alert('Error! Try again.');
                            })
                        }
                    }
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function(){
        $('.delete-comment').click(function(e){
            e.preventDefault();
            var commentID = $(this).attr('data-comment-id');
            var parent = $(this).parent("div");
            bootbox.dialog({
                message: "Are you sure you want to delete this comment?",
                title: "<i class='glyphicon glyphicon-trash'></i>",
                buttons: {
                    basic: {
                        label: "No",
                        className: "",
                        callback: function() {
                            $('.bootbox').modal('hide');
                        }
                    },
                    danger: {
                        label: "Yes, Delete it!",
                        className: "btn-danger",
                        callback: function() {
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo ROOT . "posts/"?> deleteComment/' + commentID
                            })
                                .done(function(){
                                    parent.fadeOut('slow');
                                })
                                .fail(function(){
                                    bootbox.alert('Error! Try again.');
                                })
                        }
                    }
                }
            });
        });
    });
</script>

<?php require 'theme/footer.php' ?>
