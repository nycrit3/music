<?php
    include("./inc/conn.php");

    $trackid = $_GET["track"];

    // check if track exists
    $sql = "SELECT * FROM tracks WHERE track_id = '$trackid'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // track exists
        $row = $result->fetch_assoc();
        $title = $row["title"];
        $author = $row["upload_author"];
        $album = $row["album"];
        $explicit = $row["explicit"];
        $label = $row["label"];
        $genre = $row["genre"];
        $songfile = $row["songfile"];
        $artwork = $row["artwork"];
        $year = $row["year"];
        $content_uploaded = $row["content_uploaded"];
        $downloads_enabled = $row["downloads_enabled"];
        $comments_enabled = $row["comments_enabled"];
        

        // check if user is logged in
        if (isset($_SESSION["username"])) {
            // user is logged in
            // get users timezone
            $username = $_SESSION["username"];
            $sql = "SELECT * FROM users WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();

            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $timezone = $row["timezone"];

            // convert time to users timezone if its set
            if ($timezone != "") {
                $date = new DateTime($content_uploaded, new DateTimeZone("UTC"));
                $date->setTimezone(new DateTimeZone($timezone));
                $content_uploaded = $date->format("F d, Y");
            }else{
                $content_uploaded = $row["content_uploaded"];
            }
        } else {
            $content_uploaded = $row["content_uploaded"];
        }
    } else {
        // track does not exist
        header("Location: ./home.php");
    }

    // check if user is posting a comment
    if (isset($_POST["postcomment"])) {
        // user is posting a comment
        $comment = $_POST["comment"];
        $user = $_SESSION["username"];
        $sql = "INSERT INTO comments (on_track, author, comment) VALUES ('$trackid', '$user', '$comment')";
        if ($conn->query($sql) === TRUE) {
            // comment posted successfully
            header("Location: ./track.php?track=" . $trackid);
        } else {
            // comment not posted
            echo "comment not posted";
        }
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
            <!-- artwork -->
            <img src="<?php echo "./" . htmlspecialchars($artwork); ?>" alt="Album Artwork" height="100" style="border: 1px solid black;">
            <!-- inline block -->
            <div style="display: inline-block; margin-left: 0.5em; vertical-align:top">
                <strong style="font-size: 30px;"><?php echo htmlspecialchars($title); ?></strong>
                <?php
                    if ($explicit == 1) {
                        echo '<img src="./_static/explicit.png" alt="Explicit" height="20">';
                    }
                ?>
                <br><span><?php echo "<a href='./user.php?username=" . $author . "'>" . $author . "</a>"; ?> &bull; <?php echo htmlspecialchars($year); ?></span>
                <br>
                <small style="color:gray">Uploaded <?php echo htmlspecialchars($content_uploaded); ?></small>
                <?php
                    // check if track is featured
                    $sql = "SELECT featured FROM tracks WHERE track_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $trackid);
                    $stmt->execute();

                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();

                    if ($row["featured"] != 0) {
                        echo '<br><img src="./_static/star.png" height="14"> <small style=\'color:gray\'><strong>Featured #' . $row["featured"] . '</strong></small>';
                    }

                    // if the user is logged in and they own the track or they are admin, show the delete button
                    if (isset($_SESSION["username"])) {
                        $username = $_SESSION["username"];
                        $sql = "SELECT * FROM users WHERE username = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $username);
                        $stmt->execute();

                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                        if ($row["admin_p"] == 1 || $row["username"] == $author) {
                            echo "<br><br>";
                            echo '<a href="./api/download.php?track=' . $trackid . '"><button style="background:darkgreen;color:white;font-weight:bold;">Download</button></a>&nbsp;';
                            echo '<a href="./api/delete.php?track=' . $trackid . '"><button style="background:darkred;color:white;font-weight:bold;">Delete Track</button></a><br>';
                            echo "<br><strong><small>Downloads Enabled: </small></strong>";
                            if ($downloads_enabled == 1) {
                                echo "<strong style='color:darkgreen'><small>Yes</small></strong>";
                            } else {
                                echo "<strong style='color:darkred'><small>No</small></strong>";
                            }
                            echo "<br><strong><small>Comments Enabled: </small></strong>";
                            if ($comments_enabled == 1) {
                                echo "<strong style='color:darkgreen'><small>Yes</small></strong>";
                            } else {
                                echo "<strong style='color:darkred'><small>No</small></strong>";
                            }
                        }
                    }
                ?>
                <br><br>
                <?php
                    if ($album != "") {
                        echo '<strong>Album:</strong><span> ' . htmlspecialchars($album) . '</span><br>';
                    }
                    if ($label != "") {
                        echo '<strong>Label:</strong><span> ' . htmlspecialchars($label) . '</span><br>';
                    }
                    if ($genre != "") {
                        // capitalize first letter
                        $genre = ucfirst($genre);
                        echo '<strong>Genre:</strong><span> ' . htmlspecialchars($genre) . '</span><br>';
                    }
                ?>
                <!-- if explicit, show the image -->
                <?php
                    if ($explicit == 1) {
                        echo '<br><img src="./_static/explicit_wordmark.png" alt="Explicit" height="35"><br>';
                    }
                ?>
                <br>
                <audio controls>
                    <source src="<?php echo "./" . htmlspecialchars($songfile); ?>" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
            </div><br><hr>
            <strong style="font-size:20px;">Comments</strong><br>
            <textarea style="resize:none" name="comment" id="comment" cols="70" rows="4"></textarea><br>
            <button name='postcomment' type="submit">Post</button>
            <hr>
        </div>
    </div>
</body>
</html>