<?php

include_once(__DIR__ . "/classes/User.php");


if(!empty($_POST)){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(User::canLogin($username, $password)){ 
        session_start(); 

        $_SESSION["username"] = $username;
        $_SESSION["userId"] = User::getUserIdByName($username);

        header("location: index.php");

    } else {
        $error = "Username or password are incorrect.";
    }
}



?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Log in</title>
</head>
<body>
    
<div id="app">


    <form action="login.php" method="post">
      <div class="logo">
          <img src="images/logo-app.png">
        <h1>TODO-APP</h1>
      </div>

    <nav class="nav--login">
        <a href="#" id="text">Log in to continue</a>
    </nav>
  


    <?php if(isset($error)): ?>
    <div class="alert">Username or password are incorrect.</div>
    <?php endif; ?>






  <div class="form form--login">
    <label for="username">Username</label>
    <input type="text" id="username" name="username">
  
    <label for="password">Password</label>
    <input type="password" id="password" name="password">
  </div>
  
  
  <input type="submit" value="log in" class="btn">

  <div class="signup">
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </div>
        
  </form>
</div>

</body>
</html>
