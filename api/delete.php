<?php
    include("../inc/conn.php");

    $track = $_GET["track"];

    // check if track exists
    $sql = "SELECT * FROM tracks WHERE track_id = '$track'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // if user is an admin or the track owner
        if ($_SESSION["username"] == $row["username"] || $_SESSION["admin_p"] == 1) {
            // delete track
            $sql = "DELETE FROM tracks WHERE track_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $track);
            $stmt->execute();

            // delete comments
            $sql = "DELETE FROM comments WHERE on_track = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $track);
            $stmt->execute();
        } else {
            // user is not an admin or the track owner
            header("Location: ../home.php");
        }
    }
?>