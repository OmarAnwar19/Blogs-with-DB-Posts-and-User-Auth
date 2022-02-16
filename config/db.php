<?php
    //Connect to db
    $conn = mysqli_connect("localhost", "host", "host", "blogcom");

    if (!$conn) {
        echo ("Connection error: ".mysqli_connect_error());
    }
?>