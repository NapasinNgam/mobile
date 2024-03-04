<?php 
 include ("config.php");

 if(isset($_GET['id']))
{
    $id = $_GET['id'];

    $coordinates = array();
    $latitudes = array();
    $longitudes = array();

    $restsql = "SELECT * FROM `rest` WHERE `Rest_ID`= $id";
    $query_run = mysqli_query($objCon,$restsql);
    $restdetail = mysqli_fetch_array($query_run);

                                
    $latitudes[] = $restdetail['locationLatitude'];
    $longitudes[] = $restdetail['locationLongitude'];
    $coordinates[] = 'new google.maps.LatLng(' . $restdetail['locationLatitude'] .','. $restdetail['locationLongitude'] .'),';
    $lastcount = count($coordinates)-1;
    $coordinates[$lastcount] = trim($coordinates[$lastcount], ","); 

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
    <div class="bottom-bar">
        <ul class="menu">
            <li class="home-icon"><a href="homepage.html"><img src="home.png" alt="home"></a></li>
            <li class="fav-icon"><a href="Fav.php"><img src="star.png" alt="home"></a></li>
            <li class="history-icon"><a href="history.html"><img src="time-past.png" alt="home"></a></li>
            <li class="profile-icon"><a href="Profile.php"><img src="user.png" alt="home"></a></li>
        </ul>
    </div>
    <header class="HeaderDetail">
        <?php if($_GET['from'] == '1'){
            echo "<a href='Fav.php' class='back'> < ย้อนกลับ</a>";
        }
        else if($_GET['from'] == '2'){
            $return = "SELECT * FROM history WHERE Rest_ID = '$id' ";
            $return2 = mysqli_query($objCon,$return);
            $return3 = mysqli_fetch_array($return2);
            ?><a href="historyDetail.php?type=<?php echo urlencode($return3['Type']); ?>&date=<?php echo urlencode($return3['Date']); ?>">< ย้อนกลับ</a><?php
        }
        ?>
    </header>
    <!-- Screen -->
    <div class="Screen_Rest">
        <!-- Picture -->
        <?php echo '<img src="data:image;base64,'.base64_encode($restdetail['Pic']).'"style = "width:100%; height:125px; object-fit:cover; opacity:50%; z-index:1; position:relative; ">';?>
        <div class="Rest_Content">
        <!-- Name Tiltle -->
            <div class="Rest_Name">
                <h1><?php echo $restdetail['Rest_Name'];?></h1>
            </div>  
        <!-- Google Map -->
            <div class="outer-scontainer">
                <div id="map" style="width: 100%; height: 200px; border-radius: 15px; z-index:;">
                </div>
            </div>
        <!-- Location Link -->
            <?php echo "<h3><a href=".$restdetail['Rest_Link']." target='_blank' >Or Location Link Here</a></h3>";?>
            <h3>เมนูแนะนำ</h3>
            <!-- Menu List -->
            <div class="MenuSection">
                <div class="Menu">
                    <img src="https://i.ibb.co/6vTTmLr/photo.jpg" alt="ratingstar" width="175">
                    <h5>ไก่ย่าง</h5>
                </div>
                <div class="Menu">
                    <img src="jge_template_pork_slice-bg-noname-06.jpg" alt="ratingstar" width="175">
                    <h5>เนื้อสไลด์</h5>
                </div>
                <div class="Menu">
                    <img src="https://i.ibb.co/6vTTmLr/photo.jpg" alt="ratingstar" width="175">
                    <h5>ข้าวมันไก่</h5>
                </div>
                <div class="Menu">
                    <img src="https://i.ibb.co/6vTTmLr/photo.jpg" alt="ratingstar" width="175">
                    <h5>ก๋วยเตี๋ยวเรือ</h5>
                </div>
                <div class="Menu">
                    <img src="https://i.ibb.co/6vTTmLr/photo.jpg" alt="ratingstar" width="175">
                    <h5>ไก่ย่าง</h5>
                </div>
            </div>
            <!-- Rating -->
            <div class="Rating" style="display:flex;">
                <table>
                    <tr>
                        <td style="box-sizing: fit-content; width:100px;"> <?php echo "</br><img src='https://i.ibb.co/wYQGCtT/360-F-540091788-Av-Dy-NUSbtn-KQf-Nccuku-Fa3-Zls-HFn-MYr-K.png' width='40' height='40'>
                                    <h1>".$restdetail['Rest_Rating']."</h1>";?> </td>
                        <td> <button type="submit">5 Stars</button> <button type="submit">4 Stars</button> <button type="submit">3 Stars</button>
                             <button type="submit">2 Stars</button><button type="submit">1 Star</button></td>
                    </tr>
                </table> 
            </div>

                    <script>
                        function initMap() {
                        var mapOptions = {
                            zoom: 17,
                            center: {<?php echo'lat:'. $latitudes[0] .', lng:'. $longitudes[0] ;?>}, //{lat: --- , lng: ....}
                            mapTypeId: google.maps.MapTypeId.SATELITE
                        };

                        var map = new google.maps.Map(document.getElementById('map'),mapOptions);

                        var RouteCoordinates = [
                            <?php
                                $i = 0;
                                while ($i < count($coordinates)) {
                                    echo $coordinates[$i];
                                    $i++;
                                }
                            ?>
                        ];

                        var RoutePath = new google.maps.Polyline({
                            path: RouteCoordinates,
                            geodesic: true,
                            strokeColor: '#1100FF',
                            strokeOpacity: 1.0,
                            strokeWeight: 10
                        });

                        mark = 'img/mark.png';
                        flag = 'img/flag.png';

                        
                        endPoint = {<?php echo'lat:'.$latitudes[$lastcount] .', lng:'. $longitudes[$lastcount] ;?>};


                        var marker = new google.maps.Marker({
                        position: endPoint,
                        map: map,
                        icon: flag,
                        title:"End point!",
                        animation: google.maps.Animation.DROP
                        });

                        RoutePath.setMap(map);
                        }

                        google.maps.event.addDomListener(window, 'load', initialize);
                    </script>
            
                    <!--remenber to put your google map key-->
                    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPNjVkDCsNIuk3L-7yBwa83cRcx8EqDWo&callback=initMap"></script>

        </div>
    </div>
</body>
                    