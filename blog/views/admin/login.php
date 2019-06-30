<?php
$title = $data['title'];
require 'theme/header.php';
?>

<main>
    <div class="container">
        <h2 class="text-center">Log in to administrator panel</h2>
        <br><br><br><br>
        <div class="offset-sm-3 col-sm-6">
            <form class="form-horizontal" action="" method="post">

                <div class="form-group row">
                    <label class="control-label col-sm-2" for="email">Username:</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" placeholder="Enter admin username" name="admin_username">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-sm-2" for="pwd">Password:</label>
                    <div class="col-sm-12">
                        <input type="password" class="form-control" placeholder="Enter admin password" name="admin_password">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12 text-center">
                        <button type="submit" name="login" class="btn btn-outline-dark btn-lg">Login</button>
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

    </div>
</main>
<?php require 'theme/footer.php' ?>
