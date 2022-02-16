<?php 
    session_start();
    require("./config/db.php");
    require("./config/getPoster.php");

    if (isset($_GET["id"])) {
        $post_id = mysqli_real_escape_string($conn, $_GET["id"]);

        $sql = "SELECT * FROM posts WHERE id=$post_id;";
        $result = mysqli_query($conn, $sql);
        $post = mysqli_fetch_assoc($result);
    }

?>

<!DOCTYPE html>
<html lang="en">
    <?php include("templates/header.php"); ?>

    <?php if (isset($_SESSION["auth"])) { ?>
    <div class="container center brand-text">
        <?php if ($post) { ?>

            <div class="card-content center">
                <h4>
                    <?php echo htmlspecialchars($post["title"])." - ".
                    "<i>".getPoster($conn, htmlspecialchars($post['user_id'])).
                    "</i>";?>
                </h4>
                <h6><?php echo htmlspecialchars($post["body"]);?></h6>
            </div>
        <?php } else { ?>
            <h4 class="center brand-text"><?php echo ("Post does not exist."); ?></h4>
        <?php } ?>
    </div>
    <?php } else { ?>
        <h4 class="center brand-text">Log-in to view posts</h4>
    <?php } ?>
    <p class="center"><a href="index.php">Go back to all posts.</a></p>

    <?php include("templates/footer.php"); ?>
</html>