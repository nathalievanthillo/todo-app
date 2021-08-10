<?php

    if(!empty($_POST)){ // we checken hier of er gepost wordt wanneer er op submit is geklikt 
        //email & passwoord zijn variable
        $email = $_POST['username']; // hier halen we email onze username uit onze post array (username komt van name attribuut username)
        $options = [
            'cost' => 14, //uw wachtwoord 2 tot de 14de keer gaan opnieuw hashen 
        ];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT, $options); //wat we uitlezen vanuit formulier
         
        //voor dat we wachtwoord gaan bewaren gaan incrypteren zodat het niet leesbaar is


        $conn = new PDO('mysql:host=localhost;dbname=todo', "root" , "root"); //connectie maken met databank
        $query = $conn->prepare("insert into users (email, password) values (:email, :password)"); // we gaan hier op onze connectie een voorbereiding maken en daarin een query schrijven
                                                                             //hierboven zijn placeholders waar uiteindelijk de data moet inkomen
        $query->bindValue(":email", $email); //op parameter email komt onze variable email terecht
        $query->bindValue(":password", $password); //op parameter password komt onze variable password terecht
        $query->execute();             
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
    <form action="register.php" method="post">
    <div class="logo">
          <img src="images/logo-app.png">
        <h1>TODO-APP</h1>
      </div>

    <nav class="nav--login">
        <a href="#" id="text">Sign in to continue</a>
    </nav>
  
    <div class="alert hidden">That password was incorrect. Please try again</div>




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
  
  <input type="submit" value="Sign up" class="btn">

  <div class="signup">
            <p>Already have an account? <a href="login.php">Log in</a></p>
        </div>

  </form>
</div>
</body>
</html>