<?php 

    session_start();
    require("./config/db.php");

    if(!(isset($_SESSION["auth"]))) {
        $_SESSION["message"] = "Please log in to create a post.";
        header("Location: index.php");
        die();
    }

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
        $title = mysqli_real_escape_string($conn, $_POST["title"]);
        $body = mysqli_real_escape_string($conn, $_POST["body"]);
        $id = $_SESSION["id"];
    
        $sql = "INSERT INTO posts (user_id, title, body) VALUES ('$id', '$title', '$body');";
    
        if(mysqli_query($conn, $sql)){
            session_start();
            
            $_SESSION["message"] = "Post created successfully!";
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
        <h4 class="center">Create a Post!</h4>
        <form action="post.php" class="white post-form" method="POST">

            <label for="title">Title</label>
            <textarea type="text" name="title" placeholder="Type here..." class="title-text"></textarea>
            <div class="red-text"><?php echo $errors["title"];?></div>

            <label for="body">Body</label>
            <textarea type="text" name="body" placeholder="Type here..." class="body-text"></textarea>
            <div class="red-text"><?php echo $errors["body"];?></div>

            <div class="center">
                <input type="submit" name="submit" value="Post" class="btn brand z-depth-0">
            </div>
        </form>
    </section>

    <?php include('templates/footer.php'); ?>
</html>