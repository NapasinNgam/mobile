<?php
session_start();
$username = $_SESSION['username'];
include('config.php');

    $type = $_GET['type'];
    $id = $_GET['id'];

    if ($type == '3') {
        $sql = "INSERT INTO favlist (Movie_ID,type_id,username) VALUE ('$id','$type','$username')";
        $q = mysqli_query($objCon,$sql);
        if ($q){
            echo "Success";
            if (isset($_GET['from'])){
                $return = "SELECT * FROM history WHERE Movie_ID = '$id' ";
                $return2 = mysqli_query($objCon,$return);
                $return3 = mysqli_fetch_array($return2);
                $url = "historyDetail.php?type=" . urlencode($return3['Type']) . "&date=" . urlencode($return3['Date']);
                header("Location: " . $url);
            }
            else {
                header('location:TestRandom.php');
            }
        }
        else
        {
                echo "Error";
        }
    }
    else if ($type == '1'){
        $sql = "INSERT INTO favlist (Song_ID,type_id,username) VALUE ('$id','$type','$username')";
        $q = mysqli_query($objCon,$sql);
        if ($q){
            echo "Success";
            if (isset($_GET['from'])){
                $return = "SELECT * FROM history WHERE Song_ID = '$id' ";
                $return2 = mysqli_query($objCon,$return);
                $return3 = mysqli_fetch_array($return2);
                $url = "historyDetail.php?type=" . urlencode($return3['Type']) . "&date=" . urlencode($return3['Date']);
                header("Location: " . $url);
            }
            else {
                header('location:RanDomSong.php');
            }
        }
        else
        {
                echo "Error";
        }
    }
    else if ($type == '2'){
        $sql = "INSERT INTO favlist (Rest_ID,type_id,username) VALUE ('$id','$type','$username')";
        $q = mysqli_query($objCon,$sql);
        if ($q){
            echo "Success";
            if (isset($_GET['from'])){
                $return = "SELECT * FROM history WHERE Rest_ID = '$id' ";
                $return2 = mysqli_query($objCon,$return);
                $return3 = mysqli_fetch_array($return2);
                $url = "historyDetail.php?type=" . urlencode($return3['Type']) . "&date=" . urlencode($return3['Date']);
                header("Location: " . $url);
            }
            else {
                header('location:RanDomSong.php');
            }
        }
        else
        {
                echo "Error";
        }
       
    }
?>