<?php
    include("../inc/conn.php");

    // check if user is admin
    $username = $_SESSION["username"];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if ($row["admin_p"] == 0) {
        // user is not admin
        header("Location: ../home.php");
    }

    if(isset($_POST["query"])) {
        $username = $_POST["username"];

        // check if username exists
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // username exists
            $row = $result->fetch_assoc();
            $username = $row["username"];
            $created = $row["account_created"];
            $last_ip = $row["last_ip"];
            $admin_p = $row["admin_p"];
            $email = $row["email"];
        } else {
            // username does not exist
            header("Location: ./home.php");
        }
    }

    if(isset($_POST["feature"])) {
        // set all tracks with a featured value other than 0 to 0
        $sql = "UPDATE tracks SET featured = ? WHERE featured != ?";
        $stmt = $conn->prepare($sql);
        $featured = 0;
        $stmt->bind_param("ss", $featured, $featured);
        $stmt->execute();

        $trackid = $_POST["trackid"];
        $trackid2 = $_POST["trackid2"];
        $trackid3 = $_POST["trackid3"];

        // check if track exists
        $sql = "SELECT * FROM tracks WHERE track_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $trackid);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // set featured to 1 for $trackid
        $sql = "UPDATE tracks SET featured = ? WHERE track_id = ?";
        $stmt = $conn->prepare($sql);
        $featured = 1;
        $stmt->bind_param("ss", $featured, $trackid);
        $stmt->execute();

        // set featured to 2 for $trackid2
        $sql = "UPDATE tracks SET featured = ? WHERE track_id = ?";
        $stmt = $conn->prepare($sql);
        $featured = 2;
        $stmt->bind_param("ss", $featured, $trackid2);
        $stmt->execute();

        // set featured to 3 for $trackid3
        $sql = "UPDATE tracks SET featured = ? WHERE track_id = ?";
        $stmt = $conn->prepare($sql);
        $featured = 3;
        $stmt->bind_param("ss", $featured, $trackid3);
        $stmt->execute();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/music.css">
    <link rel="shortcut icon" href="../_static/music.png" type="image/gif">
    <title>music.nycrite.lol</title>
</head>
<body>
    <div class="main">
        <div>
            <img src="../_static/favicon.gif" alt="Music GIF" height="40">
            <div style="display: inline-block; margin-left: 0.5em;">
                <strong style="font-size: x-large;">music.nycrite.lol</strong><sup style="color:red;"> admin</sup><br>
                <span>Community-driven music platform for all types of music.</span>
            </div>
            <hr>
            <span><a href="../home.php">home</a> | <a href="../api/logout.php">logout</a></span>
            <hr>
            <strong style="font-size: 30px;">Admin Panel</strong><br>
            <span>Manage users, tracks, and more.</span><hr>
            <hr>
            <fieldset>
                <legend><strong>Query user by Username</strong></legend>
                <form method="post">
                    <input type="text" name="username" placeholder="Username" required><br>
                    <input type="submit" name="query" value="Query">
                </form>
                <?php
                    if(isset($_POST['query'])) {
                        echo "<hr>";
                        echo "<strong style=\"font-size: 30px;\">User Information</strong><br>";
                        echo "<span>Username: " . htmlspecialchars($username) . "</span><br>";
                        echo "<span>Account Created: " . $created . "</span><br>";
                        echo "<span>Last IP: " . $last_ip . "</span><br>";
                        echo "<span>Admin: " . $admin_p . "</span><br>";
                        echo "<span>Email: " . $email . "</span><br>";
                        echo "<hr>";
                        echo "<strong style=\"font-size: 30px;\">Actions</strong><br>";
                        echo "<span><a href=\"../user.php?username=" . htmlspecialchars($username) . "\">View User</a></span><br>";
                        echo "<span><a href=\"./edit.php?username=" . htmlspecialchars($username) . "\">Edit User</a></span><br>";
                        echo "<span><a href=\"./delete.php?username=" . htmlspecialchars($username) . "\">Delete User</a></span><br>";
                        echo "<hr>";
                        echo "<strong style=\"font-size: 30px;\">All Tracks</strong><br>";
                        // get tracks from db where upload_author = $username
                        $sql = "SELECT * FROM tracks WHERE upload_author = '$username'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // tracks exist
                            while($row = $result->fetch_assoc()) {
                                $title = $row["title"];
                                $author = $row["upload_author"];
                                $id = $row["track_id"];
                                $date = $row["year"];
                                $genre = $row["genre"];
                                $explicit = $row["explicit"];
                                $artwork = $row["artwork"];

                                echo "<span><a href='../track.php?track=" . $id . "'>" . $title . "</a>";
                                if ($explicit == 1) {
                                    echo " <img src=\"../_static/explicit.png\" alt=\"Explicit\" height=\"15\">";
                                }
                                echo "</span><br>";
                            }
                        } else {
                            // tracks do not exist
                            echo "<span>No tracks found.</span><br>";
                        }
                    }
                ?>
            </fieldset><br>
            <fieldset>
                <legend><strong>Feature Tracks</strong></legend>
                <form method="post">
                    <strong>#1 </strong><input type="text" name="trackid" placeholder="Track ID" required><br>
                    <strong>#2 </strong><input type="text" name="trackid2" placeholder="Track ID" required><br>
                    <strong>#3 </strong><input type="text" name="trackid3" placeholder="Track ID" required><br>
                    <input type="submit" name="feature" value="Feature">
                </form>
            </fieldset>
        </div>
    </div>
</body>
</html>