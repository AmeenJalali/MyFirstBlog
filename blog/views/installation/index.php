<?php
    $title = $data['title'];
    $blog_name = $title;
    require 'theme/header.php';
?>

<main>
    <div class="container">
        <h2 class="text-center">Blog Installation</h2>
        <form class="form-horizontal" action="" method="post">
            <div class="form-group row">
                <label class="control-label col-sm-2" for="email">Blog name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Enter blog name" name="blog_name">
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-sm-2" for="email">Username:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Enter admin username" name="admin_username">
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-sm-2" for="email">Email:</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" placeholder="Enter admin email address" name="admin_email">
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-sm-2" for="pwd">Password:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" placeholder="Enter admin password" name="admin_password">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12 text-center">
                    <button type="submit" name="install" class="btn btn-outline-dark btn-lg">Install</button>
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

    </div>
</main>
<?php require 'theme/footer.php' ?>
