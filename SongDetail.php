<?php
include ("config.php");

 if(isset($_GET['id']))
 {
    $id = $_GET['id'];

    $restsql = "SELECT * FROM `music` WHERE `Song_ID`= $id";
    $query_run = mysqli_query($objCon,$restsql);
    $songdetail = mysqli_fetch_array($query_run);
 }?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Guestbook</title>
<link rel="stylesheet" type="text/css" href="style.css">
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
    <header class="HeaderDetail">
        <?php if($_GET['from'] == '1'){
            echo "<a href='Fav.php' class='back'> < ย้อนกลับ</a>";
        }
        else if($_GET['from'] == '2'){
            $return = "SELECT * FROM history WHERE Song_ID = '$id' ";
            $return2 = mysqli_query($objCon,$return);
            $return3 = mysqli_fetch_array($return2);
            ?><a href="historyDetail.php?type=<?php echo urlencode($return3['Type']); ?>&date=<?php echo urlencode($return3['Date']); ?>">< ย้อนกลับ</a><?php
        }
        ?>
    </header>
    <!-- SongScreen -->
    <div class=ScreenMovie>
        <!-- กรอปเพลง -->
        <div class="Cover" style="width:300px; height:auto; margin:20px; padding:30px; background-color:gray;" >
            <!-- รูปปกบั้ม -->
            <?php echo '<img src="'.$songdetail['Music_Pic'].'" style="width:100% height:100%">';?>
        </div>
        <!-- รายละเอียด -->
        <div class="songdetail">
            <h3><?php echo $songdetail['Song_Name'];?></h3>
            <p><?php echo "Artist : " .$songdetail['Artist'];?></p>
            <p><?php echo "Album : " .$songdetail['AlbumName'];?></p>
            <p><?php echo "Genre : " .$songdetail['Genre'];?></p>
        </div>
    </div>
</body>