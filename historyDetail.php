<?php
session_start();
$username = $_SESSION['username'];
date_default_timezone_set('asia/bangkok');
include("config.php");

function displayStarRating($rating) {
    $fullStar = '<span class="full-star">★</span>';
    $emptyStar = '<span class="empty-star">★</span>';
    $rating = floatval($rating);
    $output = '';
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $rating) {
            $output .= $fullStar;
        } else {
            $output .= $emptyStar;
        }
    }
    return $output;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Page</title>
    <link rel="stylesheet" href="historyDetail.css">
    <style>
        /* CSS สำหรับการแสดงดาวแนวนอน */
        .star-rating {
            font-size: 20px; /* ขนาดของดาว */
        }

        .star-rating span {
            display: inline-block;
            width: 20px; /* ขนาดกว้างของแต่ละดาว */
            overflow: hidden; /* ป้องกันการแสดงข้อความที่เกินขนาดที่กำหนด */
            text-align: center; /* จัดให้อยู่กึ่งกลางตามแนวนอน */
        }

        /* สีของดาวเต็ม */
        .star-rating .full-star {
            color: gold;
        }

        /* สีของดาวว่าง */
        .star-rating .empty-star {
            color: lightgrey;
        }
    </style>
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
    <div class="header">
        <a href="history.php"><img src="angle-left.png" alt=""><h3>History</h3></a>
    </div>
    <?php
    $type = $_GET['type'];
    $date = $_GET['date'];
    $sql = "SELECT * FROM history WHERE Type = '$type' AND Date = '$date' AND Username = '$username'";
    $query = mysqli_query($objCon,$sql);
    while ($rows = mysqli_fetch_array($query)) {
        if ($type == '1'){
            $id = $rows['Song_ID'];
            $test = "SELECT * FROM music WHERE Song_ID = $id";
            $hot = mysqli_query($objCon,$test);
            $dog = mysqli_fetch_array($hot);
            {
            ?><div class="container">
                    <img src="<?php echo $dog['Music_Pic'];?>" alt="">
                    <div class="data">
                        <a href='SongDetail.php?from=2&id=<?php echo $dog['Song_ID'];?>'>
                        <h6><?php echo $dog['Song_Name'];?></h6>
                        <p><?php echo $dog['Genre'];?></p>
                        <p><?php echo $dog['Artist'];?></p></a>
                        <a href="FavInsert.php?from=1&type=<?php echo urlencode($dog['Type']); ?>&id=<?php echo urlencode($dog['Song_ID']); ?>"><span class="star"><img src="heart.png" alt=""></span> </a>
                    </div>
                </div>
            <?php
            }
        }
        else if ($type == '2'){
            $id = $rows['Rest_ID'];
            $test = "SELECT * FROM rest WHERE Rest_ID = $id";
            $hot = mysqli_query($objCon,$test);
            $dog = mysqli_fetch_array($hot);
            {
            ?><div class="container">
                    <?php echo '<img src="data:image;base64,'.base64_encode($dog['Pic']).'">';?>
                    <div class="data">
                        <a href='Detail.php?from=2&id=<?php echo $dog['Rest_ID'];?>'>
                        <h6><?php echo $dog['Rest_Name'];?></h6>
                        <p><?php echo $dog['Rest_Type'];?></p></a>
                        <div class="star-rating">
                            <?php echo displayStarRating($dog['Rest_Rating']);?>
                        </div>
                        <a href="FavInsert.php?from=1&type=<?php echo urlencode($dog['Type']); ?>&id=<?php echo urlencode($dog['Rest_ID']); ?>"><span class="star"><img src="heart.png" alt=""></span> </a>
                    </div>
                </div>
            <?php
            }
        }
        else if ($type == '3'){
            $id = $rows['Movie_ID'];
            $test = "SELECT * FROM movie WHERE Movie_ID = $id";
            $hot = mysqli_query($objCon,$test);
            $dog = mysqli_fetch_array($hot);
            {
            ?><div class="container">
                    <img src="<?php echo $dog['Movie_Pic'];?>" alt="">
                    <div class="data">
                        <a href='MovieDetail.php?from=2&id=<?php echo $dog['Movie_ID'];?>'>
                        <h6><?php echo $dog['Movie_Name'];?></h6>
                        <p><?php echo $dog['Movie_genre'];?></p>
                        <a href="FavInsert.php?from=1&type=<?php echo urlencode($dog['Type']); ?>&id=<?php echo urlencode($dog['Movie_ID']); ?>"><span class="star"><img src="heart.png" alt=""></span> </a>
                    </div>
                </div>
            <?php
            }
        } 
    }
    ?>
</body>
</html>
