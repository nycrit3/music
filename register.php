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
            <strong style="font-size: 30px;">Create an account to upload music and upvote tracks.</strong><br><br>
            <span>Stream a unique crowdsourced library of music for free - no cost to you.</span><hr>
            <form action="./api/register.php" method="post">
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="text" name="email" placeholder="Email address" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <input type="checkbox" name="agree" id="agree"><span> I agree to the <a href="#">Community Policy</a> and will upload music that does not infringe on any rights.</span><br>
                <span style="color:lightcoral">Something happened.</span><br>
                <input type="submit" value="Log In">
            </form>
        </div>
    </div>
</body>
</html>