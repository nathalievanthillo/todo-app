<?php

  function canLogin($username, $password){ //variable username & password zijn placeholders voor de functie canLogin
    $conn = new PDO('mysql:host=localhost;dbname=todo', "root" , "root");
    $statement = $conn->prepare("select * from users where email = :email"); //user er uitlezen we hebben hash nodig om deze te vergelijken terug bij die hash kunnen geraken, statement preparen op onze connectie
    $statement->bindValue(":email", $username);//op het statement bindvalue van :email gelijkstellen aan username
    $statement->execute();//query uitvoeren
    $user = $statement->fetch();//uit dit statement de user halen fetch all alle records fetch = 1 record
   
    if(!$user){
      return false; //foute gebruikersnaam
    }

    $hash = $user["password"];
    if(password_verify($password, $hash)){ //Kijkt wachtwoord na in bcrypt
      return true;
    }else{
      return false;
    }
  }

  if(!empty($_POST)){ //als de array post niet leeg is dan weet je dat er is verzonden dan gaan we die pas uitlezen
    $username = $_POST['username']; //username is gelijk aan uit de post array de variable username (lezen we uit vanuit POST)
    $password = $_POST['password']; //password is gelijk aan uit de post array de variable password (lezen we uit vanuit POST)


    if(canLogin($username, $password)){ //als deze username met dat password gelijk is aan true
      session_start(); //onthouden dat een gebruiker is ingelogd en moeten worden opgestart worden en kan je aan sever vragen of hij een klein stukje data voor jou kan reserveren en daarin te stoppen op de server
      $_SESSION["username"] = $username; //server onthoud wie ik ben en ook als ik naar een andere pagina ga + session cookie wordt gestokeerd en sessie heeft een unieke nummer
      header("location: index.php"); //login die succesvol is worden geredirect naar de dashboard pagina

    } else { //Wanneer je niet juiste username & password hebt ingegeven
      $error = true; //wordt een error getoond + een foutmelding wordt nooit hier afgedrukt boven de html code
    }
  }

   

?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/login.css">
  <title>Document</title>
</head>
<body>
<div id="app">

<!--form action kan je ook leeg laten dan is het de huidige pagina-->
<!--bij een get methode komt de data in de URL te staan = onveilig, bij zoekformulieren wel van toepassing-->
<!--Post is een super global-->
    <form action="login.php" method="post">
      <div class="logo">
          <img src="images/logo-app.png">
        <h1>TODO-APP</h1>
      </div>

    <nav class="nav--login">
        <a href="#" id="text">Log in to continue</a>
    </nav>
  

    <!--is een variable geset met de naam error, staat er een naam met de naam error-->
    <?php if(isset($error)): ?>
    <!--Bestaat er een variable met de naam error dan gaan we onderstaand blok uitvoeren & tonen we de foutmelding-->
    <div class="alert">That password was incorrect. Please try again</div>
    <?php endif; ?>



  <div class="form form--login">
    <label for="username">Username</label>
    <!--Inputvelden moeten een id hebben maar ook een name attribuut krijgen anders wordt er niets doorgestuurd naar de backend -->
    <input type="text" id="username" name="username">
  
    <label for="password">Password</label>
    <!--Inputvelden moeten een id hebben maar ook een name attribuut krijgen anders wordt er niets doorgestuurd naar de backend -->
    <input type="password" id="password" name="password">
  </div>
  
  <div class="form form--signup hidden">
    <label for="username2">Username</label>
    <input type="text" id="username2">
  
    <label for="password2">Password</label>
    <input type="password" id="password2">
    
    <label for="email">Email</label>
    <input type="text" id="email">
  </div>
  
  <input type="submit" value="log in" class="btn">

  <div class="signup">
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </div>
        
  </form>
</div>
</body>
</html>