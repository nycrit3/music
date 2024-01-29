<?php
    include("./inc/conn.php");

    if (isset($_SESSION["username"])) {
        // user is logged in
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
            <hr>
            <span><a href="./login.php">login</a> | <a href="./register.php">register</a></span>
            <hr>
            <img src="./_static/featured.png" alt="Featured Icon" height="20"><strong style="font-size: x-large;">&nbsp;featured</strong><hr>
            <div class="featured">
                <div class="featured-item-1">
                    <strong style="font-size: xx-large;">#1 </strong>
                    <img src="./_static/placeholder-album.png" alt="Album Artwork" height="25" style="border: 1px solid black;">
                    <span style="font-size:30px;font-weight: bold;">&nbsp;Artist - Track</span>
                </div>
                <div class="featured-item-2">
                    <strong style="font-size: large;">#2 </strong>
                    <img src="./_static/placeholder-album.png" alt="Album Artwork" height="15" style="border: 1px solid black;">
                    <span style="font-size:20px;font-weight: bold;">&nbsp;Artist - Track</span>
                </div>
                <div class="featured-item-2">
                    <strong style="font-size: large;">#3 </strong>
                    <img src="./_static/placeholder-album.png" alt="Album Artwork" height="15" style="border: 1px solid black;">
                    <span style="font-size:20px;font-weight: bold;">&nbsp;Artist - Track</span>
                </div>
                <div class="featured-item-2">
                    <strong style="font-size: large;">#4 </strong>
                    <img src="./_static/placeholder-album.png" alt="Album Artwork" height="15" style="border: 1px solid black;">
                    <span style="font-size:20px;font-weight: bold;">&nbsp;Artist - Track</span>
                </div>
                <div class="featured-item-2">
                    <strong style="font-size: large;">#5 </strong>
                    <img src="./_static/placeholder-album.png" alt="Album Artwork" height="15" style="border: 1px solid black;">
                    <span style="font-size:20px;font-weight: bold;">&nbsp;Artist - Track</span>
                </div>
            </div>
            <hr>
            <img src="./_static/discover-icon.gif" alt="Discover Icon" height="30"><strong style="font-size: x-large;">&nbsp;discover</strong><hr>
            <div class="discover">
                <div class="discover-item">
                    <img src="./_static/placeholder-album.png" alt="Album Artwork" height="30" style="border: 1px solid black;">
                    <span style="font-size:25px;font-weight: bold;">&nbsp;Artist - Track</span>&nbsp;<span><small>1 streams</small></span><br>
                </div>
                <div class="discover-item">
                    <img src="./_static/placeholder-album.png" alt="Album Artwork" height="30" style="border: 1px solid black;">
                    <span style="font-size:25px;font-weight: bold;">&nbsp;Artist - Track</span>&nbsp;<span><small>1 streams</small></span><br>
                </div>
                <div class="discover-item">
                    <img src="./_static/placeholder-album.png" alt="Album Artwork" height="30" style="border: 1px solid black;">
                    <span style="font-size:25px;font-weight: bold;">&nbsp;Artist - Track</span>&nbsp;<span><small>1 streams</small></span><br>
                </div>
                <div class="discover-item">
                    <img src="./_static/placeholder-album.png" alt="Album Artwork" height="30" style="border: 1px solid black;">
                    <span style="font-size:25px;font-weight: bold;">&nbsp;Artist - Track</span>&nbsp;<span><small>1 streams</small></span><br>
                </div>
            </div>
        </div>
    </div>
</body>
</html>