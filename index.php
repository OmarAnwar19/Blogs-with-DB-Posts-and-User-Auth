<?php 

    session_start();
    require("./config/db.php");
    require("./config/getPoster.php");

    $param = $value = "";

    //IF IS SET SERACH, OUTPUT THE SORTED POSTS, OTHERWISE, OUTPUT ALL POSTS
    if (isset($_GET["search"])) {
        $param = $_GET["options"];
        $value = $_GET["search-input"];

        if ($param === "username") {
            $value = getId($conn, $value);
            $param = 'user_id';
        }

        $sql = "SELECT id, user_id, title, body FROM posts WHERE $param='$value' ORDER BY created;";
        $result = mysqli_query($conn, $sql);
        $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    } else {
        $sql = "SELECT id, user_id, title, body FROM posts ORDER BY created;";
        $result = mysqli_query($conn, $sql);
        $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

?>

<!DOCTYPE html>
<html lang="en">
    <?php include('templates/header.php'); ?>

    <?php if (isset($_SESSION["message"])) { ?>
        <h6 class="center light-green-text"><?php echo $_SESSION["message"];?></h6>
        <?php unset($_SESSION['message']);?>
    <?php } ?>

    <?php if (isset($_SESSION["auth"])) { ?>
        <h4 class="center brand-text">Posts</h4>
        <div class="search-container">
            <form action="index.php" method="GET" id="search-form">
                <label for="search-input">Search for: </label>
                <input type="search" name="search-input" placeholder="keyword...">
                    
                <label for="options">by</label>
                <select class="browser-default" name="options">
                    <option value="title">title</option>
                    <option value="username">username</option>
                </select>

                <input type="submit" name="search" value="search" class="btn brand z-depth-0">
            </form>
        </div>

        <div class="container">
            <?php if (empty($posts)) { ?>
                <h6 class="center brand-text">No posts exist!</h4><br>
            <?php } else { ?>
            <div class="row">
                    <?php foreach($posts as $post){ ?>
                        <div class="col s6 md3">
                            <div class="card z-depth-0">
                                <div class="card-content center">
                                    <h5><?php echo htmlspecialchars($post['title']);?></h6>
                                    <h6><i><?php echo getPoster($conn, htmlspecialchars($post['user_id']));?></i></h6>
                                </div>
                                <div class="card-action right-align">
                                    <a class="brand-text" href="details.php?id=<?php echo $post['id']?>">Read</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    <?php } else { ?>
        <h4 class="center brand-text">Log-in to view posts</h4>
    <?php } ?>

    <?php if (isset($_GET["search"])) { ?>
        <p class="center brand-text"><a href="index.php">Go back to all posts.</a></p>
    <?php } ?>

    <?php include('templates/footer.php'); ?>
</html>