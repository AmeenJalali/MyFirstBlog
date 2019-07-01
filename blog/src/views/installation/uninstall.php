<?php
$title = $data['title'];
$blog_name = $title;
require 'theme/header.php';
?>

<main>
    <div class="container">
        <h2 class="text-center">Are you sure you want to delete this blog?</h2>
        <form class="form-horizontal" action="" method="post">
            <div class="form-group">
                <div class="col-sm-12 text-center">
                    <button type="submit" name="uninstall" class="uninstall btn btn-danger btn-lg">Delete blog completely</button>
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
