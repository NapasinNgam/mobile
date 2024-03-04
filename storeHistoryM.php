<?php
session_start();
include('config.php');
$_POST = json_decode(file_get_contents('php://input'), true);

// Log the request data
file_put_contents('log.txt', print_r($_POST, true));

$username = $_SESSION['username'];
$title = $_POST['title'] ?? '';
$year = $_POST['year'] ?? '';
$genres = $_POST['genres'] ?? '';
$poster = $_POST['url'] ?? '';
$typeforcheck = '3';



// Perform MySQL query to insert data into 'history' table
            $sql = "INSERT INTO movie (Movie_Name , Movie_Years, Movie_genre, Movie_Pic, Type) VALUES (?, ?, ?, ?, ?)";
            $stmt = $objCon->prepare($sql);
            $stmt->bind_param("ssssi", $title, $year, $genres,  $poster, $typeforcheck);
            $stmt->execute();

            $datetime = date("y-m-d");
            $test = "SELECT * FROM movie WHERE Movie_Pic = ?";
            $stmt = $objCon->prepare($test);
            $stmt->bind_param("s", $poster);
            $stmt->execute();
            $result = $stmt->get_result();
            $id = $result->fetch_assoc();
            $movieid = $id['Movie_ID'];
            $history = "INSERT INTO history (Type,Movie_ID,Username,Date,posterM) VALUE (?, ?, ?, ?, ?)";
            $stmt = $objCon->prepare($history);
            $stmt->bind_param("sisss", $typeforcheck, $movieid, $username, $datetime, $poster);
            $stmt->execute();
            ?>