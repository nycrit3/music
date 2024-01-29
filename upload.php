<?php
    include("./inc/conn.php");

    if (!isset($_SESSION["username"])) {
        header("Location: ./login.php");
    }

    if(isset($_POST["upload"])) {
        $title = $_POST["title"];
        $album = $_POST["album"];
        $year = $_POST["year"];

        if(isset($_POST["explicit"])) {
            $explicit = 1;
        } else {
            $explicit = 0;
        }

        $genre = $_POST["genre"];
        $label = $_POST["label"];
        $producer = $_POST["producer"];
        $writer = $_POST["writer"];
        
        $comments_enabled = $_POST["comments"];
        $downloads_enabled = $_POST["downloads"];

        if(isset($_POST["comments"])) {
            $comments_enabled = 1;
        } else {
            $comments_enabled = 0;
        }

        if(isset($_POST["downloads"])) {
            $downloads_enabled = 1;
        } else {
            $downloads_enabled = 0;
        }

        // artwork upload
        $target_dir = "./_static/artwork/";
        $target_file = $target_dir . basename($_FILES["artwork"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $uploadOk = 1;

        // check if file already exists
        if (file_exists($target_file)) {
            // file already exists
            echo "file already exists";
            $uploadOk = 0;
        }

        // check file size
        if ($_FILES["artwork"]["size"] > 500000) {
            // file is too large
            echo "file is too large";
            $uploadOk = 0;
        }

        // allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            // file is not an image
            echo "file is not an image";
            $uploadOk = 0;
        }

        // check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            // file was not uploaded
            echo "file was not uploaded";
        } else {
            // file was uploaded
            if (move_uploaded_file($_FILES["artwork"]["tmp_name"], $target_file)) {
                // file was uploaded successfully
                echo "file was uploaded successfully";
                // rename file
                $new_file = $target_dir . rand(1111111,9999999) . "." . $imageFileType;
                rename($target_file, $new_file);
                // song file upload
                $target_dir = "./_static/music/";
                $target_file = $target_dir . basename($_FILES["file"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                $uploadOk = 1;

                // check if file already exists
                if (file_exists($target_file)) {
                    // file already exists
                    echo "file already exists";
                    $uploadOk = 0;
                }

                // check file size
                if ($_FILES["file"]["size"] > 50000000) {
                    // file is too large
                    echo "file is too large";
                    $uploadOk = 0;
                }

                // allow certain file formats
                if($imageFileType != "mp3" && $imageFileType != "wav" && $imageFileType != "ogg") {
                    // file is not an audio file
                    echo "file is not an audio file";
                    $uploadOk = 0;
                }

                // check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    // file was not uploaded
                    echo "file was not uploaded";
                } else {
                    // file was uploaded
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                        // file was uploaded successfully
                        echo "file was uploaded successfully";
                        // rename file
                        $new_file1 = $target_dir . rand(1111111,9999999) . "." . $imageFileType;
                        rename($target_file, $new_file1);
                        // update db
                        $user = $_SESSION["username"];
                        $sql = "INSERT INTO tracks (title, upload_author, album, year, explicit, genre, label, producers, writers, downloads_enabled, comments_enabled, artwork, songfile) VALUES ('$title', '$user', '$album', '$year', '$explicit', '$genre', '$label', '$producer', '$writer', '$downloads_enabled', '$comments_enabled', '$new_file', '$new_file1')";
                        if ($conn->query($sql) === TRUE) {
                            // db updated successfully
                            header("Location: ./home.php");
                        } else {
                            // db not updated
                            echo "db not updated";
                        }
                    } else {
                        // file was not uploaded
                        echo "file was not uploaded";
                    }
                }
            } else {
                // file was not uploaded
                echo "file was not uploaded";
            }
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
            <?php include("./inc/header.php") ?>
            <strong style="font-size:30px">Upload a track</strong><br>
            <img src="./_static/warning.png" alt="Warning" height="16"><strong style="color:red;"> Read all rules before uploading.</strong><strong> Failure to comply may result in a permanent suspension from the platform.</strong><br>
            <ul>
                <li>You may not upload copyrighted material (material that you did not create or material you do not have the rights to upload)</li>
                <li>music.nycrite.lol is a crowdsourced platform. We welcome all sorts of music! However, music that goes against our <a href="./communitypolicy.html">Community Policy</a> will be taken down.</li>
                <li>Explicit content is allowed - simply tick the "This content has explicit content" checkbox.</li>
            </ul><hr>
            <form method="post" enctype="multipart/form-data">
                <input type="text" name="title" placeholder="Title" required><br>
                <input type="text" name="album" placeholder="Album (optional)"><br>
                <input type="text" name="year" placeholder="Year" required><br><br>
                <input type="checkbox" name="explicit"><strong> Explicit lyrics/content?</strong>
                <hr>
                <strong>Optional Information</strong><br>
                <select name="genre" id="genre">
                    <option value="none">Select a genre</option>
                    <option value="alternative">Alternative</option>
                    <option value="ambient">Ambient</option>
                    <option value="blues">Blues</option>
                    <option value="classical">Classical</option>
                    <option value="country">Country</option>
                    <option value="dance">Dance</option>
                    <option value="disco">Disco</option>
                    <option value="electronic">Electronic</option>
                    <option value="folk">Folk</option>
                    <option value="funk">Funk</option>
                    <option value="hiphop">Hip-Hop</option>
                    <option value="house">House</option>
                    <option value="indie">Indie</option>
                    <option value="jazz">Jazz</option>
                    <option value="latin">Latin</option>
                    <option value="metal">Metal</option>
                    <option value="pop">Pop</option>
                    <option value="punk">Punk</option>
                    <option value="rnb">R&B</option>
                    <option value="rap">Rap</option>
                    <option value="reggae">Reggae</option>
                    <option value="rock">Rock</option>
                    <option value="soul">Soul</option>
                    <option value="techno">Techno</option>
                    <option value="trance">Trance</option>
                    <option value="trap">Trap</option>
                </select><br><br>
                <input type="text" name="label" placeholder="Label"><br>
                <input type="text" name="producer" placeholder="Producer(s)"><br>
                <input type="text" name="writer" placeholder="Writer(s)"><br><br>
                <input type="checkbox" name="downloads" id="downloads"><span> Enable downloads for this track</span><br>
                <input type="checkbox" name="comments" id="comments"><span> Allow comments</span>
                <hr>
                <strong>Track artwork: </strong><input type="file" name="artwork" id="artwork" required><br>
                <strong>Track file: </strong><input type="file" name="file" id="file" required><br>
                <input type="submit" name="upload" value="Upload">
            </form>
        </div>
    </div>
</body>
</html>