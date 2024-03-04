<?php
    include ("config.php");

    $sql = "SELECT * FROM music";
    $objQuery = mysqli_query($objCon, $sql);

    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $delete = "DELETE FROM favlist WHERE FavNum = $id";
        $query_run = mysqli_query($objCon,$delete);

        header("location:Fav.php");
    }
?>