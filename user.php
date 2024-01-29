<?php
    include("./inc/conn.php");

    $username = $_GET["username"];

    // check if username exists
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // username exists
        $row = $result->fetch_assoc();
        $username = $row["username"];

        if (isset($_SESSION["username"])) {
            // get user's timezone
            $username = $_SESSION["username"];
            $sql = "SELECT timezone FROM users WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($timezone);
            $stmt->fetch();
            $stmt->close();
            // format date into user's timezone if timezone is not null
            if ($timezone != null) {
                $date = new DateTime($row["account_created"], new DateTimeZone('UTC'));
                $date->setTimezone(new DateTimeZone($timezone));
                $date = $date->format('F d, Y');
            } else {
                $date = $row["account_created"];
            }
        }else{
            $date = $row["account_created"];
        }

        $pfp = $row["pfp"];
    } else {
        // username does not exist
        header("Location: ./home.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/music.css">
    <link rel="shortcut icon" href="./_static/music.png" type="image/gif">
    <title>music.nycrite.lol</title>
</head>
<body>
    <div class="main">
        <div>
            <img src="./_static/favicon.gif" alt="Music GIF" height="40">
            <div style="display: inline-block; margin-left: 0.5em;">
                <strong style="font-size: x-large;">music.nycrite.lol</strong><br>
                <span>Community-driven music platform for all types of music.</span>
            </div>
            <?php
                if (isset($_SESSION["username"])) {
                    // user is logged in
                    include("./inc/header.php");
                } else {
                    // user is not logged in
                    echo '<hr><span><a href="./login.php">login</a> | <a href="./register.php">register</a></span><hr>';
                }
            ?>
            <!-- profile picture -->
            <img src="<?php echo "./" . htmlspecialchars($pfp); ?>" alt="Profile Picture" height="100" style="border: 1px solid black;">
            <!-- inline block -->
            <div style="display: inline-block; margin-left: 0.5em; vertical-align:top">
                <strong style="font-size: 30px;"><?php echo htmlspecialchars($username); ?></strong><br>
                <span>Joined <?php echo htmlspecialchars($date); ?></span>
            </div><br><hr>
            <strong style="font-size: 30px;">Tracks</strong><br>
            <?php
                // get tracks from db where upload_author = $username
                $sql = "SELECT * FROM tracks WHERE upload_author = '$username'";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    // tracks exist
                    while($row = $result->fetch_assoc()) {
                        // get track info
                        $track_id = $row["track_id"];
                        $title = $row["title"];
                        $author = $row["upload_author"];
                        $album = $row["album"];
                        $explicit = $row["explicit"];
                        $featured = $row["featured"];
                        $genre = $row["genre"];
                        $songfile = $row["songfile"];
                        $artwork = $row["artwork"];
                        $year = $row["year"];
                        // display track
                        echo '<div class="track">';
                        echo '<img src="./' . htmlspecialchars($artwork) . '" alt="Album Artwork" height="50" style="border: 1px solid black;">';
                        echo '<div style="display: inline-block; margin-left: 0.5em; vertical-align:top">';
                        echo '<strong style="font-size: 20px;"><a href="track.php?track=' . $track_id . '">' . htmlspecialchars($title) . '</a></strong>';
                        if ($explicit == 1) {
                            echo ' <img src="./_static/explicit.png" alt="Explicit" height="15">';
                        }
                        echo '<br><span><a href="./user.php?username=' . $author . '">' . $author . '</a> &bull; ' . htmlspecialchars($year) . '</span><br>';
                        if ($featured != 0) {
                            echo '<img src="./_static/star.png" height="13"> <small style=\'color:gray\'><strong>Featured #' . $featured . '</strong></small>';
                        }
                        echo '</div>';
                    }
                } else {
                    // tracks do not exist
                    echo "no tracks found";
                }
            ?>
        </div>
    </div>
</body>
</html>