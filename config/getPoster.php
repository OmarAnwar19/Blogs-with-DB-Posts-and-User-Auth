<?php 

    function getPoster($conn, $user_id) {
        $sql = "SELECT username FROM users WHERE id='$user_id';";
        return mysqli_fetch_assoc(mysqli_query($conn, $sql))["username"];
    }

    function getId($conn, $username) {
        $sql = "SELECT id FROM users WHERE username='$username';";
        return mysqli_fetch_assoc(mysqli_query($conn, $sql))["id"];
    }

?>