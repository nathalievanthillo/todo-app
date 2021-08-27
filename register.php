<?php
    include_once(__DIR__ . "/classes/User.php");


    if(!empty($_POST)){ 


        try{
            $user = new User();

            $user->setUsername($_POST["username"]);
            $user->setPassword($_POST["password"]);
            $user->setEmail($_POST["email"]);

            $user->save();
            

            session_start();
            header('location: login.php');

        } catch (\Throwable $th) {
            $error = $th->getMessage();
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Register</title>
</head>
<body>

<div id="app">


    <form action="register.php" method="post">
    <div class="logo">
          <img src="images/logo-app.png">
        <h1>TODO-APP</h1>
      </div>

    <nav class="nav--login">
        <a href="#" id="text">Sign in to continue</a>  
    </nav>
  

    <?php if(isset($error)): ?>
    <div class="alert">
      <?php echo $error;?></div>
    <?php endif; ?>

   




  <div class="form form--login">
    <label for="username">Username</label>
    <input type="text" id="username" name="username">


    <label for="email">Email</label>
    <input type="text" id="email" name="email">
  
    <label for="password">Password</label>
    <input type="password" id="password" name="password">
  </div>
  
  <input type="submit" value="Sign up" class="btn">

  <div class="signup">
            <p>Already have an account? <a href="login.php">Log in</a></p>
        </div>

  </form>
</div>
    
</body>
</html>
