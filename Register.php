
<DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link rel="stylesheet" href="signup.css">
</head>
<body>
  <div class="container" method="post">
    <h2>Sign Up</h2>
    <form action="Register.php" method="post">
      <div class="username">
        <input type="text" placeholder="Enter Username" name="username" id="username">
      </div>
      <div class="email">
        <input type="email" placeholder="Enter Email" name="email" id="email">
      </div>
      <div class="password">
        <input type="password" placeholder="Enter Password" name="password" id="password">
      </div>
      <div class="confirm-password">
        <input type="password" placeholder="Confrim Password" name="repeatpassword" id="repeatpassword">
      </div>
      <?php
    if (isset($_POST['submit'])){
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordRepeat = $_POST['repeatpassword'];
            $errors = array();
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            if(empty($username) OR empty($email) OR empty($password) OR empty($passwordRepeat)){
                array_push($errors,"Please fill out all required fields");
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email is invalid");
            }
            if(strlen($password)<7){
                array_push($errors,"Password must be at least 7 characters or more");
            }
            if ($password !==$passwordRepeat){
                array_push($errors,"Please enter the correct Confrim Password");
            }
            require_once "config.php";
            $sql = "SELECT * FROM userlist WHERE username = '$username'";
            $result = mysqli_query($objCon,$sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount > 0){
                array_push($errors,"Username already exists!");
            }
            $sql = "SELECT * FROM userlist WHERE email = '$email'";
            $result = mysqli_query($objCon,$sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount > 0){
                array_push($errors,"Email already exists!");
            }
            if(count($errors)>0) {
                foreach($errors as $error) {
                //แสดงผล error
                    echo "<div class='alret'>$error</div>";
                }
            }
            else {
                require_once "config.php";
                $sql = "INSERT INTO userlist (username, password, email) VALUE ( ? , ? , ?)";
                $stmt = mysqli_stmt_init($objCon);
                $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
                if ($prepareStmt){
                    mysqli_stmt_bind_param($stmt,"sss",$username,$password,$email);
                    mysqli_stmt_execute($stmt);
                //Register Successful
                    header('location:index.php');    
                }
                else{
                    die("Some error occurred! Please Contact Developer Team");
                }
            }
        }?>
      <div class="signup-button">
        <input type="submit" placeholder="Sign In" value="Register" name="submit">
      </div>
    </form>
    <div class="login-link">
      <p>Already have an account? <a href="index.php">Log in</a></p>
    </div>
  </div>
</body>
</html>