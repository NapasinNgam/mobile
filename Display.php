<?php
    session_start();
    date_default_timezone_set ('asia/bangkok');
    $username = $_SESSION['username'];
    include("config.php");
    echo "<a href='Fav.php'>Back</a>";
    if($_GET['Name'] == 'Hall of Fame (feat. will.i.am)')
    {
        header("location:RanDomSong.php");
    }
    $typeforcheck = $_GET['Type'];

    if ($typeforcheck == '3'){
        $title = $_GET['Name'];
        $year = $_GET['Year'];
        $director = $_GET['Director'];
        $actor = $_GET['Actor'];
        $plot = $_GET['Plot'];
        $genre = $_GET['Genre'];
        $poster = $_GET['Poster'];
        $imbdid = $_GET['ImdbID'];
        $repeat = "SELECT * FROM history WHERE username = ? AND imdbID = ?";
        $stmt = $objCon->prepare($repeat);
        $stmt->bind_param("ss", $username, $imbdid);
        $stmt->execute();
        $result = $stmt->get_result();
        $rowCount = $result->num_rows;
        if ($rowCount > 0){
            header("location:TestRandom.php");
        }
        if($director == 'N/A' OR $director == 'undefined'){
            $director = '-';
        }
        if($plot == 'N/A' OR $plot == 'undefined'){
            $plot = '-';
        }
        if($genre == 'N/A' OR $genre == 'undefined'){
            $genre = '-';
        }
        if($actor == 'N/A' OR $actor == 'undefined'){
            $actor = '-';
        }
        if($poster == 'N/A' OR $poster == 'undefined'){
            $poster = 'Noposter.png';
        }
        echo "<br>Title : ".$title;
        echo "<br>Years : " .$year;
        echo "<br>Director : " .$director;
        echo "<br>Actor : ".$actor;
        echo "<br>Plot : " .$plot;
        echo "<br>genre : " .$genre;
        echo "<div><img src='$poster'></div>";
        $checkDup = "SELECT * FROM movie WHERE imdbID = ?";
        $stmt = $objCon->prepare($checkDup);
        $stmt->bind_param("s", $imbdid);
        $stmt->execute();
        $result = $stmt->get_result();
        $checkDup3 = $result->num_rows;
        if($checkDup3 <= 0){
            $sql = "INSERT INTO movie (Movie_Name , Movie_Years, Movie_Director, Movie_Actor, Movie_short, Movie_genre, imdbID, Movie_Pic, Type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $objCon->prepare($sql);
            $stmt->bind_param("sisssssss", $title, $year, $director, $actor, $plot, $genre, $imbdid, $poster, $typeforcheck);
            $stmt->execute();
        }
        if($stmt->affected_rows > 0) {
            //echo "Successful<br>";
            $datetime = date("y-m-d");
            $test = "SELECT * FROM movie WHERE imdbID = ?";
            $stmt = $objCon->prepare($test);
            $stmt->bind_param("s", $imbdid);
            $stmt->execute();
            $result = $stmt->get_result();
            $id = $result->fetch_assoc();
            $movieid = $id['Movie_ID'];
            $history = "INSERT INTO history (Type,Movie_ID,Username,Date,imdbID) VALUE (?, ?, ?, ?, ?)";
            $stmt = $objCon->prepare($history);
            $stmt->bind_param("sisss", $typeforcheck, $movieid, $username, $datetime, $imbdid);
            $stmt->execute();
        } else {
            echo "ERROR";
            //header("location:TestRandom.php");
        }
        echo "<div><a href='TestRandom.php'>Don't Like</a></div><br>";
        ?><a href="FavInsert.php?type=<?php echo urlencode($typeforcheck); ?>&id=<?php echo urlencode($movieid); ?>">I Like it</a><?php
    }
    else if ($typeforcheck == '1'){
        $title = $_GET['Name'];
        $artist = $_GET['Artist'];
        $album = $_GET['Album'];
        $genre = $_GET['Genre'];
        $poster = $_GET['Poster'];
        $preview = $_GET['Preview'];
        $youtube = $_GET['Youtube'];
        $repeat = "SELECT * FROM history WHERE username = ? AND PreviewURL = ?";
        $stmt = $objCon->prepare($repeat);
        $stmt->bind_param("ss", $username, $preview);
        $stmt->execute();
        $result = $stmt->get_result();
        $rowCount = $result->num_rows;
        if ($rowCount > 0){
            header("location:RanDomSong.php");
        }
        echo "<br>Title Track : ".$title;
        echo "<br>Artist : " .$artist;
        echo "<br>Album : " .$album;
        echo "<br>genre : " .$genre;
        echo "<br><audio controls><source src='$preview'></audio>";
        if($youtube !== 'YouTube Video Link Not Available'){
            echo "<br><a href='$youtube'>Full Song on youtube</a>";
        }
        echo "<div><img src='$poster'></div>";
        $checkDup = "SELECT * FROM music WHERE PreviewURL = ?";
        $stmt = $objCon->prepare($checkDup);
        $stmt->bind_param("s", $preview);
        $stmt->execute();
        $result = $stmt->get_result();
        $checkDup3 = $result->num_rows;
        if($checkDup3 <= 0){
            $sql = "INSERT INTO music (Song_Name, Artist, YoutubeLink, Type, PreviewURL, AlbumName, Music_Pic, Genre) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $objCon->prepare($sql);
            $stmt->bind_param("sssissss", $title, $artist, $youtube, $typeforcheck, $preview, $album, $poster, $genre);
            $stmt->execute();
        }
        if($stmt->affected_rows > 0) {
            $datetime = date("y-m-d");
            $test = "SELECT * FROM music WHERE PreviewURL = ?";
            $stmt = $objCon->prepare($test);
            $stmt->bind_param("s", $preview);
            $stmt->execute();
            $result = $stmt->get_result();
            $id = $result->fetch_assoc();
            $songid = $id['Song_ID'];
            $history = "INSERT INTO history (Type,Song_ID,Username,Date,PreviewURL) VALUE (?, ?, ?, ?, ?)";
            $stmt = $objCon->prepare($history);
            $stmt->bind_param("sisss", $typeforcheck, $songid, $username, $datetime, $preview);
            $stmt->execute();
        } else {
            echo "ERROR";
            header("location:RanDomSong.php");
        }
        ?><a href="RanDomSong.php">Don't Like</a><?php
        ?><a href="FavInsert.php?type=<?php echo urlencode($typeforcheck); ?>&id=<?php echo urlencode($songid); ?>">I Like it</a><?php
    }
    else if ($typeforcheck == '2'){
        echo "Restaurant";
        /*$title = $_GET['Name'];
        $year = $_GET['Year'];
        $director = $_GET['Director'];
        echo "Title : ".$title;
        echo " Years : " .$year;
        echo " Director : " .$director;*/
    }
?>
