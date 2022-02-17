<?php 

    require("./config/db.php");

    if(isset($_SESSION["auth"])) {
        http_response_code(404);
        header("Location: index");
        die();
    }

    $username = $email = $password = "";

    $errors = array("head"=>"", "username"=>"", "email"=>"", "password"=>"");

    if (empty($_POST["username"])) {
        $errors["username"] = "Please enter a username <br />";
    } else {
        if (!(strlen($_POST["username"]) >= 4) || 
        (strlen($_POST["username"]) > 16) || 
        !(is_string($_POST["username"]))) {
            $errors["username"] = "Username must be between 4-16 letters <br />";
        }

        $username = $_POST["username"];
    }

    if (empty($_POST["password"])) {
        $errors["password"] = "Please enter a password <br />";
    } else {
        if (!(strlen($_POST["password"])) >= 6) {
            $errors["password"] = "Password must be longer than 6 characters <br />";
        }

        $password = $_POST["password"];
    }

    if (empty($_POST["email"])) {
        $errors["email"] = "Please enter an email <br />";
    } else {
        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Please enter a valid email <br />";
        };

        $email = $_POST["email"];
    }

    if (checkUser($conn, $email, $username)) {
        $errors["head"] = "A user with that username or email already exists <br />";
    } else {
        $email = $_POST["email"] ?? "";
        $password = $_POST["password"] ?? "";
    }     

    if(!(array_filter($errors))) {
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $ptPassword = mysqli_real_escape_string($conn, $_POST["password"]);
        
        checkUser($conn, $email, $username);

        $hshPassword = password_hash($ptPassword, PASSWORD_DEFAULT);
    
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hshPassword');";
    
        if(mysqli_query($conn, $sql)){
            session_start();
            
            $_SESSION["message"] = "Registered successfully, you can now Log-in!";
            header("Location: index");
        } else {
            echo("Query error: ".mysqli_error($conn));
        }
    }

    function checkUser($conn, $email, $username) {
        $sql = "SELECT 1 FROM `users` where email='$email' or username='$username';";
        return mysqli_num_rows(mysqli_query($conn, $sql)) ? true : false;
    }

?>

<!DOCTYPE html>
<html lang="en">
    <?php include("templates/header.php"); ?>

    <section class="container brand-text">
        <h4 class="center">Register</h4>
        <form action="register" class="white" method="POST">
            <div class="red-text"><?php echo $errors["head"];?></div>

            <label for="username">Username</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($username)?>">
            <div class="red-text"><?php echo $errors["username"];?></div>

            <label for="email">Email</label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($email)?>">
            <div class="red-text"><?php echo $errors["email"];?></div>

            <label for="password">Password</label>
            <input type="password" name="password" value="<?php echo htmlspecialchars($password)?>">
            <div class="red-text"><?php echo $errors["password"];?></div>

            <div class="center">
                <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
            </div>
            <p class="center">Already have an account? <a href="login">Login</a></p>
        </form>
    </section>

    <?php include("templates/footer.php"); ?>
</html>