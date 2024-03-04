<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<footer class="bottom-bar" style="height: 50px;">
        <ul class="menu">
            <li class="home-icon"><a href="Home.html"><img src="home.png" alt="home"></a></li>
            <li class="fav-icon"><a href="Fav.php"><img src="star.png" alt="home"></a></li>
            <li class="history-icon"><a href="history.php"><img src="time-past.png" alt="home"></a></li>
            <li class="profile-icon"><a href="Profile.php"><img src="user.png" alt="home"></a></li>
        </ul>
    </footer>
    <?php
    if(empty($_SESSION['username'])){
        echo "<a href='index.php'>Login</a>
        <a href='Resgister.php'>Register</a>";
    }
    else{
        echo "<a href='Logout.php'>Logout</a>";
    }
    ?>
</body>
</html>