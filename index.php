<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="loginstyle.css">
  <title>Login page</title>
</head>
<body>
  <div class="container">
    <img src="gachaa.png" alt="">
    <form action="index.php" method="post">
            <div class = "username">
                <p>Enter Email</p>
                <input type="email" placeholder="Enter Email" name="email">
            </div>
            <div class= "password">
                <p>Enter Password</p>
                <input type="password" placeholder="Enter Password" name="password">
            </div>
            <?php
            //assdgdfgrtsgs
            if (isset($_POST['login'])){
                $email = $_POST['email'];
                $password = $_POST['password'];
                require_once "config.php";
                $sql = "SELECT * FROM userlist WHERE email = '$email'";
                $result = mysqli_query($objCon,$sql);
                $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                if($user){
                    if($password == $user['password']){
                        header("Location:User.php?username=".$user['username']);
                        die();
                    }
                    else{
                        echo "<div class='error'>Invalid Password</div>";
                    }
                }
                else{
                    echo "<div class='error'>Invalid Email</div>";
                }
            }?>
            <div class="login-button">
                <input type="submit" value="Login" name="login">
            </div>
        </form>
    
        <div class="signup-link">
            <p>Don't have an account? <a href="Register.php">Sign up</a></p>
        </div>
  </div>
</body>
</html>
