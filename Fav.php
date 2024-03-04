<?php
session_start();
include("config.php");
$username = $_SESSION['username'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Guestbook</title>
<link rel="stylesheet" type="text/css" href="Fav-1.css">
</head>

<body>
    <form action="" method="GET">
        <header class = "header">
            <h2>Favortie</h2>
            <!-- Username ทำให้อยู่ท้ายหน้าก็ได้-->
            <div class="nav">
                <ul>
                    <li><a href ='Fav.php?type=1'>Music</a>
                    <li><a href ='Fav.php?type=2'>Restaurant</a>
                    <li><a href ='Fav.php?type=3'>Movie</a>
                    <li><a href = 'Fav.php'>Reset</a>
                </ul>
            </div>
        </header>
    </form>
    <footer class="bottom-bar" style="height: 50px;">
        <ul class="menu">
            <li class="home-icon"><a href="Home.html"><img src="home.png" alt="home"></a></li>
            <li class="fav-icon"><a href="Fav.php"><img src="star.png" alt="home"></a></li>
            <li class="history-icon"><a href="history.php"><img src="time-past.png" alt="home"></a></li>
            <li class="profile-icon"><a href="Profile.php"><img src="user.png" alt="home"></a></li>
        </ul>
    </footer>
    <!-- Main Screen -->
            <?php
                if(isset($_GET['type']))
                { 
                        $typecheck = $_GET['type'];
                        $sql = "SELECT * FROM `favlist` WHERE type_id ='$typecheck' AND username = '$username'";
                        $objQuery = mysqli_query($objCon, $sql);
                        while ($rows = mysqli_fetch_array($objQuery)) 
                        if ($rows['type_id'] =='1')
                        { 
                            $id = $rows['Song_ID'];
                            $test = "SELECT * FROM music WHERE Song_ID = $id";
                            $hot = mysqli_query($objCon,$test);
                            $dog = mysqli_fetch_array($hot);
                            ?>
                            <!-- Song Box -->
                             <div class="a-container">
                                <div class="container">
                                <?php echo '<img src="'.$dog['Music_Pic'].'">';?>
                                <?php echo "<a href='SongDetail.php?from=1&id=".$dog['Song_ID']."'>
                                                   <h6> ".$dog['Song_Name']."</h6>
                                                   <p> ".$dog['Artist']."</p>
                                                   <a href=\"deletee.php?id=".$rows["FavNum"]."\">UnFav</a></a>";?>
                                
                                </div>
                            </div>
                        <?php
                        }
                        else if ($rows['type_id'] =='3')
                        { 
                            $id = $rows['Movie_ID'];
                            $test = "SELECT * FROM movie WHERE Movie_ID = $id";
                            $hot = mysqli_query($objCon,$test);
                            $dog = mysqli_fetch_array($hot);
                        ?>
                            <!-- Movie Box -->
                            <div class="a-container">
                                <div class="container">
                                <?php echo '<img src="'.$dog['Movie_Pic'].'">';?>
                                <?php echo "<a href='MovieDetail.php?from=1&id=".$dog['Movie_ID']."'>
                                                   <h6> ".$dog['Movie_Name']."</h6>
                                                   <p> ".$dog['Movie_genre']."</p>
                                                   <a href=\"deletee.php?id=".$rows["FavNum"]."\">UnFav</a></a>";?>
                                
                                </div>
                            </div>
                        <?php
                        }
                        else if ($rows['type_id'] =='2')
                        { 
                            $id = $rows['Rest_ID'];
                            $test = "SELECT * FROM rest WHERE Rest_ID = $id";
                            $hot = mysqli_query($objCon,$test);
                            $dog = mysqli_fetch_array($hot);
                            ?>
                            <div class="a-container">
                                    <div class="container">
                                    <?php echo '<img src="data:image;base64,'.base64_encode($dog['Pic']).'">';?>
                                    <?php echo "<a href='Detail.php?from=1&id=".$dog['Rest_ID']."'>
                                                    <h6> ".$dog['Rest_Name']."</h6>
                                                    <p> ".$dog['Rest_Type']."</p>
                                                    <a href=\"deletee.php?id=".$rows["FavNum"]."\">UnFav</a></a>";?>
                                    </div>
                                </div><?php
                        } 
                    
                } 
                else 
                {
                    $sql = "SELECT * FROM favlist WHERE username = '$username'";
                    $objQuery = mysqli_query($objCon, $sql);
                    while ($rows = mysqli_fetch_array($objQuery)) 
                        if ($rows['type_id'] =='1')
                        { 
                            $id = $rows['Song_ID'];
                            $test = "SELECT * FROM music WHERE Song_ID = $id";
                            $hot = mysqli_query($objCon,$test);
                            $dog = mysqli_fetch_array($hot);
                            ?>
                                <!-- Song Box -->
                                <div class="a-container">
                                    <div class="container">
                                    <?php echo '<img src="'.$dog['Music_Pic'].'">';?>
                                    <?php echo "<a href='SongDetail.php?from=1&id=".$dog['Song_ID']."'>
                                                    <h6> ".$dog['Song_Name']."</h6>
                                                    <p> ".$dog['Artist']."</p>
                                                    <a href=\"deletee.php?id=".$rows["FavNum"]."\">UnFav</a></a>";?>
                                    
                                    </div>
                            </div>
                        <?php
                        }
                        else if ($rows['type_id'] =='3')
                        { 
                            $id = $rows['Movie_ID'];
                            $test = "SELECT * FROM movie WHERE Movie_ID = $id";
                            $hot = mysqli_query($objCon,$test);
                            $dog = mysqli_fetch_array($hot);
                        ?>
                            <!-- Movie Box -->
                            <div class="a-container">
                                <div class="container">
                                <?php echo '<img src="'.$dog['Movie_Pic'].'">';?>
                                <?php echo "<a href='MovieDetail.php?from=1&id=".$dog['Movie_ID']."'>
                                                   <h6> ".$dog['Movie_Name']."</h6>
                                                   <p> ".$dog['Movie_genre']."</p>
                                                   <a href=\"deletee.php?id=".$rows["FavNum"]."\">UnFav</a></a>";?>
                                
                                </div>
                            </div>
                            <?php
                        }
                        else if ($rows['type_id'] =='2')
                        { 
                            $id = $rows['Rest_ID'];
                            $test = "SELECT * FROM rest WHERE Rest_ID = $id";
                            $hot = mysqli_query($objCon,$test);
                            $dog = mysqli_fetch_array($hot);
                        ?>
                                <!-- Resterant Box -->
                                <div class="a-container">
                                    <div class="container">
                                    <?php echo '<img src="data:image;base64,'.base64_encode($dog['Pic']).'">';?>
                                    <?php echo "<a href='Detail.php?from=1&id=".$dog['Rest_ID']."'>
                                                    <h6> ".$dog['Rest_Name']."</h6>
                                                    <p> ".$dog['Rest_Type']."</p>
                                                    <a href=\"deletee.php?id=".$rows["FavNum"]."\">UnFav</a></a>";?>
                                    </div>
                                </div>
                            <?php
                        } 
                }?>
    </div>
</body>