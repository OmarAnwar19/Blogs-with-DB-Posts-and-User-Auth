<?php 
    session_start();

    if(!(isset($_SESSION["auth"]))) {
        http_response_code(404);
        header("Location: index");
        die();
    }

    unset($_SESSION["auth"]);
    unset($_SESSION["username"]);
    unset($_SESSION["id"]);

    $_SESSION["message"] = "Logged out succesfully!";
    header("Location: index");

?>