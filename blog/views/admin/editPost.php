<?php
$title = $data['title'];
require 'theme/header.php';
?>

<main>
    <div class="container">

        <h2 class="text-center">Edit Post</h2>
        <h6 class="text-center">Hi, <?php echo $_SESSION["username"] ?>! | <a href="<?php echo ADMIN_PATH ?>">Dashboard</a> | <a href="<?php echo ADMIN_PATH . 'logout' ?>">Sign out</a></h6>

        <div class="offset-sm-3 col-sm-6">
            <form class="form-horizontal" action="" method="post">

                <?php $post = $data['post'][0] ?>
                <div class="form-group">
                    <label class="control-label" for="email">Post title:</label>
                    <input type="text" class="form-control" placeholder="Enter post title" name="post_title" value="<?php echo $post['post_title']?>">
                </div>


                <div class="form-group">
                    <label for="post_description">Post description:</label>
                    <textarea class="form-control" placeholder="Enter post description" name="post_description" rows="15" id="post_description"><?php echo $post['post_description']?></textarea>
                </div>


                <div class="form-group">
                    <div class="col-sm-12 text-center">
                        <button type="submit" name="saveChanges" class="btn btn-outline-dark btn-lg">Save changes</button>
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
<?php require 'theme/footer.php' ?>
