<?php
//อันนี้ไม่มีอะไร เอาไว้ set global
session_start();
$usernameid = $_GET['username'];
$_SESSION['username'] = $usernameid;

header("Location:Fav.php?username=".$usernameid);
?>