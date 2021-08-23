<?php
    
    include_once(__DIR__ . '/classes/Lists.php');

    session_start();

    if(!empty($_POST)){ //zodra de post niet leeg is weten we dat er iets verzonden is en laten we de variables uitlezen



        try{
            $list = new Lists();

            $list->setUserId($_SESSION["userId"]);
            $list->setTitle($_POST["title"]);
            $list->setDescription($_POST["description"]);
            $list->setDeadline($_POST["deadline"]);

            $result = $list->AddList();
            


            session_start();
            header('location: index.php');

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
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/home.css">
    <title>Add List</title>
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
    
<a href="index.php">Go Back</a>

<form action="addlist.php" method="post" enctype="multipart/form-data">
    <h2>TODO - APP</h2>

  <div class="form form--task">


    <label for="title">Title</label>
    <input type="text" id="title" name="title">


    <label for="description">Hours</label>
    <input type="text" id="description" name="description">

    <label for="deadline">Deadline</label>
    <input type="text" id="deadline" name="deadline">

    <button type="submit" name="btnSubmit" class="submitNewTask">Add List</button>
    <input type="reset" value="Reset">

    <?php if(isset($error)): ?>
    <!--Bestaat er een variable met de naam error dan gaan we onderstaand blok uitvoeren & tonen we de foutmelding-->
    <div class="alert">
      <?php echo $error;?></div>
    <?php endif; ?>

  </div>
</form>

</body>
</html>