<?php 

    require("./config/db.php");

    if(isset($_SESSION["auth"])) {
        http_response_code(404);
        header("Location: index");
        die();
    }

    $email = $password = "";

    $errors = array("head"=>"", "email"=>"", "password"=>"");

    if (empty($_POST["email"])) {
        $errors["email"] = "Please enter an email <br />";
    } else {
        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Please enter a valid email  <br />";
        };

        $email = $_POST["email"];
    }

    if (empty($_POST["password"])) {
        $errors["password"] = "Email or password incorrect <br />";
    } else {
        if (!(strlen($_POST["password"])) >= 6) {
            $errors["password"] = "Email or password incorrect  <br />";
        }

        $password = $_POST["password"];
    }

    if(!(array_filter($errors))) {

        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $ptPassword = mysqli_real_escape_string($conn, $_POST["password"]);
            
        $user = getUser($conn, $email);

        if (!($user)) {
            $errors["head"] = "Email or password incorrect <br />";            
        } else {
            if(!(password_verify($ptPassword, $user["password"]))){
                $errors["head"] = "Email or password incorrect <br />";            
            } else {
                session_start();
    
                //Set the session user 
                $_SESSION["auth"] = true;
                $_SESSION['username'] = $user["username"];
                $_SESSION['id'] = $user["id"];

                $_SESSION["message"] = "Logged in successfully, welcome ".$_SESSION['username']."!";
                header("Location: index");
            }
        }
    }

    function getUser($conn, $email) {
        $sql = "SELECT * FROM users where email='$email'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            return(mysqli_fetch_assoc($result));
        } else {
            header("Location: login");
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
    <?php include("templates/header.php"); ?>

    <section class="container brand-text">
        <h4 class="center">Login</h4>
        <form action="login" class="white" method="POST">
            <div class="red-text"><?php echo $errors["head"];?></div>

            <label for="email">Email</label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($email)?>">
            <div class="red-text"><?php echo $errors["email"];?></div>

            <label for="password">Password</label>
            <input type="password" name="password" value="<?php echo htmlspecialchars($password)?>">
            <div class="red-text"><?php echo $errors["password"];?></div>

            <div class="center">
                <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
            </div>
            <p class="center">Don't have an account? <a href="register">Register</a></p>
        </form>
    </section>

    <?php include("templates/footer.php"); ?>
</html>