<?php
include_once(__DIR__ . '/classes/User.php');
include_once(__DIR__ . '/classes/Database.php');
include_once(__DIR__ . '/classes/Lists.php');
include_once(__DIR__ . '/classes/Task.php');

session_start(); //er wordt een link gelegd tussen session id en de data op de server

$user = new User();
$list = new Lists();
$task = new Task();

$lists = $list->getLists($user);
$countlists = $list->countLists();
$countusers = $user->countUsers();

$users = $user->getUsers($user);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/home.css">
    <title>statistics</title>
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

<p class="stats">Er zijn <?php echo $countusers; ?> users</p>
<p class="stats">Er zijn <?php echo $countlists; ?> lists</p>


<p>test</p>
</body>

</html>