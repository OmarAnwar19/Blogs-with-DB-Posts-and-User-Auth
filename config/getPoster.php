<?php 

    function getPoster($conn, $user_id) {
        $sql = "SELECT username FROM users WHERE id='$user_id';";
        return mysqli_fetch_assoc(mysqli_query($conn, $sql))["username"];
    }

?>