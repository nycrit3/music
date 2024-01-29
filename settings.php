<?php
    include("./inc/conn.php");

    if(!isset($_SESSION["username"])) {
        header("Location: ./login.php");
    }

    if(isset($_POST["pfp"])) {
        // check if the user uploaded a file
        if(isset($_FILES["profile_picture"])) {
            // check if the file is an image
            $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
            if($check !== false) {
                // file is an image
                $target_dir = "./_static/pfp/";
                $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                $target_file = $target_dir . $_SESSION["username"] . "." . $imageFileType;
                $uploadOk = 1;
                // check if file already exists
                if (file_exists($target_file)) {
                    // file already exists
                    echo "file already exists";
                    $uploadOk = 0;
                }
                // check file size
                if ($_FILES["profile_picture"]["size"] > 500000) {
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
                    if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                        // file was uploaded successfully
                        echo "file was uploaded successfully";
                        // rename file
                        $new_file = $target_dir . rand(1111111,9999999) . "." . $imageFileType;
                        rename($target_file, $new_file);
                        // update db
                        $sql = "UPDATE users SET pfp = '$new_file' WHERE username = '" . $_SESSION["username"] . "'";
                        if ($conn->query($sql) === TRUE) {
                            // db updated successfully
                            header("Location: ./settings.php");
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
                // file is not an image
                echo "file is not an image";
            }
        } else {
            // user did not upload a file
            echo "user did not upload a file";
        }
    }

    if(isset($_POST["timezone1"])) {
        // update db
        // get timezone
        $timezone = $_POST["timezone"];

        // prepared statement
        $stmt = $conn->prepare("UPDATE users SET timezone = ? WHERE username = ?");
        $stmt->bind_param("ss", $timezone, $_SESSION["username"]);
        $stmt->execute();
        $stmt->close();
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
            <strong style="font-size: 30px;">Settings</strong><br>
            <span>Change your account settings.</span><hr>
            <form method="post">
                <!-- profile picture -->
                <input type="file" name="profile_picture"> <input type="submit" name="pfp" value="Change Profile Photo">
            </form>
            <hr><strong>Time</strong><br>
            <span>Change your timezone.</span>
            <form method="post">
                <select name="timezone">
                    <option value="America/New_York">Eastern Time</option>
                    <option value="America/Chicago">Central Time</option>
                    <option value="America/Denver">Mountain Time</option>
                    <option value="America/Phoenix">Mountain Time (no DST)</option>
                    <option value="America/Los_Angeles">Pacific Time</option>
                    <option value="America/Anchorage">Alaska Time</option>
                    <option value="Pacific/Honolulu">Hawaii Time</option>
                    <option value="Pacific/Samoa">Samoa Time</option>
                    <option value="Pacific/Guam">Chamorro Time</option>
                    <option value="Pacific/Wake">Wake Time</option>
                    <option value="Pacific/Chuuk">Chuuk Time</option>
                    <option value="Pacific/Pohnpei">Pohnpei Time</option>
                    <option value="Pacific/Kosrae">Kosrae Time</option>
                    <option value="Pacific/Noumea">New Caledonia Time</option>
                    <option value="Pacific/Fiji">Fiji Time</option>
                    <option value="Pacific/Tongatapu">Tonga Time</option>
                    <option value="Pacific/Apia">Apia Time</option>
                    <option value="Pacific/Kiritimati">Line Islands Time</option>
                </select>
                <input type="submit" name="timezone1" value="Change Timezone">
            </form>
        </div>
    </div>
</body>
</html>