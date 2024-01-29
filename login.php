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
            <span><a href="#">login</a> | <a href="#">register</a></span>
            <hr>
            <strong style="font-size: 30px;">Log in to your account and get back to streaming original music.</strong><br><br>
            <span>No account? Create one <a href="register.html">here</a>.</span><hr>
            <form action="./api/login.php" method="post">
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <span style="color:lightcoral">There was an error accessing your account with the credientials provided.</span>
                <input type="submit" value="Log In">
            </form>
        </div>
    </div>
</body>
</html>