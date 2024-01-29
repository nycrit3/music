<?php
    include("../inc/conn.php");

    $username = $_POST["username"];
    $password = $_POST["password"];

    // check if username exists
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // username exists
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            // password is correct
            $_SESSION["username"] = $username;
            header("Location: ../home.php");
        } else {
            // password is incorrect
            echo "password is incorrect";
        }
    } else {
        // username does not exist
        echo "username does not exist";
    }
?>