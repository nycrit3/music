<?php
    include("../inc/conn.php");

    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $email = $_POST["email"];

    // get user ipv4 address
    $ip = $_SERVER['REMOTE_ADDR'];

    // check if username exists
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // username exists
        echo "username exists";
    } else {
        // username does not exist
        // check if email exists
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // email exists
            echo "email exists";
        } else {
            // email does not exist
            // insert user into db
            $sql = "INSERT INTO users (username, password, email, last_ip) VALUES ('$username', '$password', '$email', '$ip')";
            if ($conn->query($sql) === TRUE) {
                // user inserted successfully
                $_SESSION["username"] = $username;
                header("Location: ../home.php");
            } else {
                // user not inserted
                echo "error";
            }
        }
    }

?>