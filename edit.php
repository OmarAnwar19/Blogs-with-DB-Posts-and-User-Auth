<?php 

    session_start();
    require("./config/db.php");

    if(!(isset($_SESSION["auth"]))) {
        $_SESSION["message"] = "Insufficient permissions.";
        header("Location: index.php");
        die();
    }

    if (isset($_POST["save"])) {
        $post_id = mysqli_real_escape_string($conn, $_POST["post_id"]);
    } else {
        $post_id =  $_GET["id"];
    }

    $sql = "SELECT * FROM posts WHERE id=$post_id;";
    $result = mysqli_query($conn, $sql);
    $post = mysqli_fetch_assoc($result);
    $post_id = $post["id"];

    $title = $post["title"];
    $body = $post["body"];

    $errors = array("title"=>"", "body"=>"");

    if (empty($_POST["title"])) {
        $errors["title"] = "Please enter a title... <br />";
    } else {
        if (!(strlen($_POST["title"])) > 100) {
            $errors["title"] = "Title can not be longer than 100 characters <br />";
        }
        $title = $_POST["title"];
    }

    if (empty($_POST["body"])) {
        $errors["body"] = "Please enter some body text... <br />";
    } else {
        if (strlen($_POST["body"]) < 50) {
            $errors["body"] = "Body text must be longer than 50 characters. <br />";
        }

        $body = $_POST["body"];
    }

    if(!(array_filter($errors))) {
        $post_id = mysqli_real_escape_string($conn, $_POST["post_id"]);
        $title = mysqli_real_escape_string($conn, $_POST["title"]);
        $body = mysqli_real_escape_string($conn, $_POST["body"]);
    
        $sql = "UPDATE posts SET title='$title', body='$body' WHERE id='$post_id';";
    
        if(mysqli_query($conn, $sql)){
            session_start();
            
            $_SESSION["message"] = "Post edited successfully!";
            header("Location: index.php");
        } else {
            echo("Query error: ".mysqli_error($conn));
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
    <?php include('templates/header.php'); ?>
    
    <section class="container brand-text">
        <h4 class="center">Edit Post:</h4>
        <form action="edit.php" class="white post-form" method="POST">

            <label for="title">Title</label>
            <textarea type="text" name="title" placeholder="Type here..." class="title-text"><?php echo $title;?></textarea>
            <div class="red-text"><?php echo $errors["title"];?></div>

            <label for="body">Body</label>
            <textarea type="text" name="body" placeholder="Type here..." class="body-text"><?php echo $body;?></textarea>
            <div class="red-text"><?php echo $errors["body"];?></div>

            <div class="center">
                <input type="hidden" name="post_id" value="<?php echo $post['id'];?>">
                <input type="submit" name="save" value="save" class="btn brand z-depth-0">
            </div>
        </form>
    </section>

    <?php include('templates/footer.php'); ?>
</html>