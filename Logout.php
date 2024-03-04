<?php
//อันนี้ก็ไม่มีอะไรหน้า Log out
session_start();

$_SESSION['username'] = NULL;

header("location:index.php");
?>