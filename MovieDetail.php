<?php 
 include ("config.php");

 if(isset($_GET['id']))
 {
    $id = $_GET['id'];

    $restsql = "SELECT * FROM `movie` WHERE `Movie_ID`= $id";
    $query_run = mysqli_query($objCon,$restsql);
    $moviedetail = mysqli_fetch_array($query_run);                            
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
            <li class="home-icon"><a href="homepage.html"><img src="home.png" alt="home"></a></li>
            <li class="fav-icon"><a href="Fav.php"><img src="star.png" alt="home"></a></li>
            <li class="history-icon"><a href="history.html"><img src="time-past.png" alt="home"></a></li>
            <li class="profile-icon"><a href="Profile.php"><img src="user.png" alt="home"></a></li>
        </ul>
    </footer>
    <header class="HeaderDetail">
        <?php if($_GET['from'] == '1'){
            echo "<a href='Fav.php' class='back'> < ย้อนกลับ</a>";
        }
        else if($_GET['from'] == '2'){
            $return = "SELECT * FROM history WHERE Movie_ID = '$id' ";
            $return2 = mysqli_query($objCon,$return);
            $return3 = mysqli_fetch_array($return2);
            ?><a href="historyDetail.php?type=<?php echo urlencode($return3['Type']); ?>&date=<?php echo urlencode($return3['Date']); ?>">< ย้อนกลับ</a><?php
        }
        ?>
    </header>
    <div class=ScreenMovie>
    <!-- ปื้นพลังที่เป็นตั๋ว -->
        <div class="Ticket">
            <!-- รูปปกบนตั๋ว -->
            <div class="MovieCover">
                <?php echo '<img src="'.$moviedetail['Movie_Pic'].'">';?>
            </div>
            <!-- ส่วนบนตั๋ว -->
            <div class="MovieName">
                <table>
                    <tr>
                        <td><?php echo $moviedetail['Movie_Name'];?></td>
                        <td><?php echo $moviedetail['Movie_genre'];?></td>
                    </tr>
                </table>
            </div>
            <!-- ส่วนรายละเอียดตั๋ว-->
            <div class="MainTicket">
                <h3><?php echo $moviedetail['Movie_Name'];?></h3>
                <p><?php echo "นักแสดงนำ : " .$moviedetail['Movie_Actor'];?></p>
                <p><?php echo "     " .$moviedetail['Movie_short'];?></p>
            </div>
        </div>
    </div>
</body>
