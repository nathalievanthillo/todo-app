<?php

    session_start(); //er wordt een link gelegd tussen session id en de data op de server
    //isset is = bestaat die variable
    if(isset($_SESSION['username'])){   //kijkt of er iets gesset is of er in de session of er in de session een array bestaat met de naam username (naam van session)
        //user is logged in
        //echo "Welcome " . $_SESSION['username'];
        //queries
    }else{
        //user is not logged in
        header("location: login.php"); //je wordt teruggestuurd naar login.php
    }

    

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Document</title>
</head>
<body>
<header>
  <nav class="nav">
    <a href="#" class="loggedIn">
      <div class="user--avatar"><img src="images/image-user.png" alt=""></div>
  
      <span class="user--status">Welcome</span>
      <!--als er geset is uit de session vakje username-->
      <?php if(isset($_SESSION['username'])): ?> 
      <!--doen we onderstaand blok gaan we de username vanuit de session printen-->
      <h3 class="user--name"><?php echo $_SESSION['username']; ?></h3>
      <?php else: ?> <!--als die sessie niet bestaat wordt username here afgeprint-->
      <h3 class="user--name">Username here</h3>
      <?php endif; ?>

    </a>
    <a href="logout.php">Log out</a>
  </nav>    
</header>

<div class="list">
    <h2>TODO APP</h2>
   

    <div class="not-done">
    <ul>
    <h4>Edit</h4>
    <h3>Not done</h3>
    <li>
    <label>
    <input type="checkbox" name="">
    <p>Pay rent</p>
    <span></span>
    </label>
    </li>


    <li>
    <label>
    <input type="checkbox" name="">
    <p>Call dad</p>
    <span></span>
    </label>
    </li>
    </ul>
    </div> 

    <div class="done">
    <ul>
    <h4>Edit</h4>
    <h3>Done</h3>
    <li>
    <label>
    <input type="checkbox" name="">
    <p>Book Flight to London</p>
    <span></span>
    </label>
    </li>


    <li>
    <label>
    <input type="checkbox" name="">
    <p>Work on Class</p>
    <span></span>
    </label>
    </li>

    <li>
    <label>
    <input type="checkbox" name="">
    <p>Make Haircut Appt.</p>
    <span></span>
    </label>
    </li>


    <li>
    <label>
    <input type="checkbox" name="">
    <p>Plan Date Night</p>
    <span></span>
    </label>
    </li>


    </div>
    </div>


</body>
</html>
