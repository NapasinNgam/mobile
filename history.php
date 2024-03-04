<?php
session_start();
date_default_timezone_set ('asia/bangkok');
$username = $_SESSION['username'];
include("config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Page</title>
    <link rel="stylesheet" href="history-1.css">
</head>

<body>
    <div class="header">
        <h2>History</h2>
        <div class="nav">
            <ul>
                <li><a href="history.php?filter=1">Music</a></li>
                <li><a href="history.php?filter=2">Restaurant</a></li>
                <li><a href="history.php?filter=3">Movie</a></li>
                <li><a href="history.php">Reset</a></li>
            </ul>
        </div>
    </div>

    <footer class="bottom-bar" style="height: 50px;">
        <ul class="menu">
            <li class="home-icon"><a href="Home.html"><img src="home.png" alt="home"></a></li>
            <li class="fav-icon"><a href="Fav.php"><img src="star.png" alt="home"></a></li>
            <li class="history-icon"><a href="history.php"><img src="time-past.png" alt="home"></a></li>
            <li class="profile-icon"><a href="Profile.php"><img src="user.png" alt="home"></a></li>
        </ul>
    </footer>
    <?php 
if(isset($_GET['filter'])){
    $filtertype = $_GET['filter'];
    $sql = "SELECT DISTINCT(Date) FROM `history` WHERE `type` = '$filtertype' AND username = '$username' ORDER BY Date DESC";
    $objQuery = mysqli_query($objCon, $sql);
    while($rows = mysqli_fetch_array($objQuery))
    {
        $date = $rows['Date'];
        if (date("Y-m-d") == date($date))
        {
            $dateDisplay = 'Today';
        }
        else if (date("Y-m-d",strtotime('yesterday')) == date($date)){
            $dateDisplay = 'Yesterday';
        }
        else if (date("Y-m-d",strtotime("-2 Day")) == date($date))
        {
            $dateDisplay = '2 Days Ago';
        }
        else if (date("Y-m-d",strtotime("-3 Day")) == date($date))
        {
            $dateDisplay = '3 Days Ago';
        }
        else
        {
            $dateDisplay = date($date);
        }
      ?><div class="container">
            <div class="date">
                <h6><?php echo $dateDisplay;?></h6>
        </div>
        <div class="image-gacha scroll-container">
        <?php $typeCheck = "SELECT DISTINCT(Type) FROM `history` WHERE Date = '$date' AND `type` = '$filtertype'"; 
        $q = mysqli_query($objCon,$typeCheck);
        while($typeE = mysqli_fetch_array($q))
        {
            $Atype = $typeE['Type'];
        if ($Atype == '1'){
            $Atype = 'Music';
            $pic = 'Gacha2.png';
        }
        else if ($Atype == '2'){
            $Atype = 'Restaurant';
            $pic = 'Gacha1.png';
        }
        else if ($Atype == '3'){
            $Atype = 'Movie';
            $pic = 'Gacha3.png';
        }
        ?>
            <a href="historyDetail.php?type=<?php echo $typeE['Type'].'&date=' . $date;?>">
                <img src="<?php echo $pic?>" alt="">
                <figcaption><?php echo $Atype;?></figcaption>
            </a>
            <?php
        }
        ?>
        </div>
    </div>
        <?php
    }
}
else {
    $sql = "SELECT DISTINCT(Date) FROM `history` WHERE username = '$username' ORDER BY Date DESC";
    $objQuery = mysqli_query($objCon, $sql);
    while($rows = mysqli_fetch_array($objQuery))
    {
        $date = $rows['Date'];
        if (date("Y-m-d") == date($date))
        {
            $dateDisplay = 'Today';
        }
        else if (date("Y-m-d",strtotime('yesterday')) == date($date)){
            $dateDisplay = 'Yesterday';
        }
        else if (date("Y-m-d",strtotime("-2 Day")) == date($date))
        {
            $dateDisplay = '2 Days Ago';
        }
        else if (date("Y-m-d",strtotime("-3 Day")) == date($date))
        {
            $dateDisplay = '3 Days Ago';
        }
        else
        {
            $dateDisplay = date($date);
        }
      ?><div class="container">
      <div class="date">
          <h6><?php echo $dateDisplay;?></h6>
  </div>
    <div class="image-gacha scroll-container">
    <?php $typeCheck = "SELECT DISTINCT(Type) FROM `history` WHERE Date = '$date'"; 
    $q = mysqli_query($objCon,$typeCheck);
    while($typeE = mysqli_fetch_array($q))
    {
        $Atype = $typeE['Type'];
        if ($Atype == '1'){
            $Atype = 'Music';
            $pic = 'Gacha2.png';
        }
        else if ($Atype == '2'){
            $Atype = 'Restaurant';
            $pic = 'Gacha1.png';
        }
        else if ($Atype == '3'){
            $Atype = 'Movie';
            $pic = 'Gacha3.png';
        }
        ?>
            <a href="historyDetail.php?type=<?php echo $typeE['Type'].'&date=' . $date;?>">
                <img src="<?php echo $pic?>" alt="">
                <figcaption><?php echo $Atype;?></figcaption>
            </a>
        <?php
    }
    ?>
    </div>
            </div>
            <?php
            }
        }
    ?>
</body>

</html>