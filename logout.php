<?php 

    if(!(isset($_SESSION["auth"]))) {
        http_response_code(404);
        header("Location: index.php");
        die();
    }

    session_start();

    unset($_SESSION["auth"]);
    unset($_SESSION["username"]);
    unset($_SESSION["id"]);

    $_SESSION["message"] = "Logged out succesfully!";
    header("Location: index.php");

?>