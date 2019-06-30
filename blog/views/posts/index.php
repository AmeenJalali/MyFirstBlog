<?php
$title = $data['title'];
require 'theme/header.php';
$post = $data['post'];
$comments = $data['comments'];
?>

<main>
    <div class="container">

        <?php
            echo "<div><p><h1 class='text-center'>" . $post[0]['post_title'] . "</h1></p>";
            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
                echo "<a href=\"" . ADMIN_PATH . "editPost/" . $post[0]['post_id'] . "\" class=\"btn btn-xs btn-info\">Edit</a>";
            }
            echo "<p>Post id: " . $post[0]['post_id'] . " , Published date: " . $post[0]['post_published_date'] . "</p>";
            echo "<p>" . $post[0]['post_description'] . "</p>";
            echo "</div>";
        ?>

        <br>
        <hr>
        <br>


        <h5>Comments:</h5>
        <?php

        if (sizeof($comments) == 0) {
            echo "No comments found";
        } else {
            for ($i = 0; $i < sizeof($comments); $i++) {
                echo "<div>";
                echo $comments[$i]['comment_author_name'] . " - " . $comments[$i]['comment_author_email'] . " - " . $comments[$i]['comment_published_date'];

                if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
                    echo " <a href=\"\" data-comment-id=\"" . $comments[$i]['comment_id'] . "\" class=\"delete-comment btn btn-xs btn-danger\">Delete</a>";
                }

                echo "<br>";
                echo $comments[$i]['comment_description'];
                echo "<br><hr></div>";
            }
        }
        ?>


        <div class="offset-sm-3 col-sm-6">
            <form class="form-horizontal" action="" method="post">

                <div class="form-group">
                    <label class="control-label" for="email">Your name:</label>
                    <input type="text" class="form-control" placeholder="Enter your name" name="comment_author">
                </div>

                <div class="form-group">
                    <label class="control-label" for="email">Your Email:</label>
                    <input type="text" class="form-control" placeholder="Enter your email address" name="comment_email">
                </div>


                <div class="form-group">
                    <label for="post_description">Comment:</label>
                    <textarea class="form-control" placeholder="Write your comment here" name="comment_description" rows="5"></textarea>
                </div>


                <div class="form-group">
                    <div class="col-sm-12 text-center">
                        <button type="submit" name="send" class="btn btn-outline-dark btn-lg">Send</button>
                    </div>
                </div>

            </form>
            <?php
            if ($data['errors'] != "") {
                echo "<div class=\"alert alert-danger\" role=\"alert\">";
                echo $data['errors'];
                echo "</div>";
            }
            ?>
            <?php
            if ($data['success'] != "") {
                echo "<div class=\"alert alert-success\" role=\"alert\">";
                echo $data['success'];
                echo "</div>";
            }
            ?>
        </div>


    </div>
</main>

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
