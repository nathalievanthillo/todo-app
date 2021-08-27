<?php
include_once(__DIR__ . '/classes/User.php');
include_once(__DIR__ . '/classes/Database.php');
include_once(__DIR__ . '/classes/Lists.php');
include_once(__DIR__ . '/classes/Task.php');

session_start(); 

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
      <?php if(isset($_SESSION['username'])): ?> 
      <h3 class="user--name"><?php echo (htmlspecialchars($_SESSION['username'])); ?></h3>
      <?php else: ?> 
      <h3 class="user--name">Username here</h3>
      <?php endif; ?>

    </a>
    <a href="logout.php">Log out</a>

    
  </nav>    
</header>
<div class="navigationStatics">
<a href="index.php">Go Back</a>
</div>
<div class="allStats">
<h2>Statistics</h2>
</div>

<div class="infoList">
    <div class="dataList">
<div class="userStats">
<h3>Users</h3>
<p class="statsUser">There are <b><?php echo $countusers; ?></b> users</p>
</div>

<div class="listStats">
<h3>Lists</h3>
<p class="statsLists">There are <b><?php echo $countlists; ?></b> lists</p>
</div>
</div>
</div>
</body>

</html>
