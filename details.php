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

    if (isset($_POST["delete"])) {
        $del_id = mysqli_real_escape_string($conn, $_POST["del_id"]);

        $sql =  "DELETE FROM `posts` WHERE id='$del_id'";
        if(mysqli_query($conn, $sql)) {
            $_SESSION['message'] = 'Post deleted.';

            header("Location: index.php");
            die();
        } else {
            echo("Query error: ".mysqli_error($conn));
        }
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
    <?php } else { ?>
        <h4 class="center brand-text">Log-in to view posts</h4>
    <?php } ?>
    <?php if ($post["user_id"] === $_SESSION["id"]) { ?>
        <form action="details.php" method="POST">
                <input type="hidden" name="del_id" value="<?php echo $post['id'];?>">
                <input type="submit" name="delete" value="delete" class="btn brand z-depth-0">
        </form>
    <?php } ?>
    <p><a href="index.php">Go back to all posts.</a></p>
    </div>

    <?php include("templates/footer.php"); ?>
</html>