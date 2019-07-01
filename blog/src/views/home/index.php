<?php
$title = $data['title'];
require 'theme/header.php';
?>

<main>
    <div class="container">
        <h2 class="text-center">Last Posts</h2>

        <?php
        $posts = $data['posts'];
        if (sizeof($posts) == 0) {
            echo "No posts found";
        } else {
            for ($i = 0; $i < sizeof($posts); $i++) {
                echo "<a href=\"" . ROOT . "posts/viewpost/" . $posts[$i]['post_id'] . "\"><div><p><h3>" . $posts[$i]['post_title'] . "</h3></p></a>";
                echo "<div class=\"row text-secondary\">";
                echo "<div class=\"col-2\"><p><i class=\"far fa-clipboard\"></i> Post id: " . $posts[$i]['post_id'] . "</div>" .
                "<div class=\"col-10\"><i class=\"far fa-calendar-alt\"></i> Published date: &nbsp" . $posts[$i]['post_published_date'] . "</div></p>";
                echo "</div>";
                echo "<p>" . limited_echo($posts[$i]['post_description'], 700) . "</p>";
                echo "<i class=\"fas fa-angle-right\"></i> <a href=\"" . ROOT . "posts/viewpost/" . $posts[$i]['post_id'] . "\">Read more</a>";
                echo "<hr></div>";
            }
        }
        ?>


    </div>
</main>

<?php
function limited_echo($text, $length)
{
    if(strlen($text)<=$length) {
        echo $text;
    } else {
        echo substr($text,0, $length) . '...';
    }
}
?>
<?php require 'theme/footer.php' ?>
