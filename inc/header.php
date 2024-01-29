<hr>
            <span>welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span><br>
            <?php
                // check if user is admin
                $username = $_SESSION["username"];

                $sql = "SELECT * FROM users WHERE username = '$username'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                if ($row["admin_p"] == 1) {
                    // user is admin
                    echo "<a style='color: red;' href='./admin/home.php'>admin</a> |";
                }
            ?>
            <span><a href="home.php">home</a> | <a href="upload.php">upload</a> | <a href="user.php?username=<?php echo htmlspecialchars($_SESSION['username']); ?>">profile</a> | <a href="settings.php">settings</a> | <a href="api/logout.php">logout</a></span>
            <hr>