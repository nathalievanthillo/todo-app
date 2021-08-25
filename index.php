<?php

include_once(__DIR__ . '/classes/Lists.php');
include_once(__DIR__ . '/classes/Task.php');
include_once(__DIR__ . '/classes/TaskComment.php');
include_once(__DIR__ . '/classes/User.php');

    session_start(); //er wordt een link gelegd tussen session id en de data op de server



  $AllListsForUser[] = NULL; //declareren van de variable
  $AllTasksForListsAndUser[] = NULL;

    //isset is = bestaat die variable
    if(isset($_SESSION['username'])){   //kijkt of er iets gesset is of er in de session of er in de session een array bestaat met de naam username (naam van session)
        //user is logged in
        //echo "Welcome " . $_SESSION['username'];
        //queries



        if(!isset($_GET['listId'])){ //wanneer we niet in een lijst zitten alle lijsten opvragen
         
            $AllListsForUser = Lists::getAllListsByUserId($_SESSION['userId']); //alle lijsten tonen van de ingelogde user
          

          
        } else {
          

          if(isset($_GET['order'])){

            $AllTasksForListsAndUser = Task::getAllTasksByHours($_SESSION['userId'], $_GET['listId']);

          }else{

            $AllTasksForListsAndUser = Task::getAllTasksByUserAndListId($_SESSION['userId'], $_GET['listId']); //user uit session halen en de lijst uit de get (url)
          }
          }


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
    <link rel="stylesheet" href="css/home.css">
    <title>Home</title>
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

<?php if(User::IsAdmin($_SESSION['userId'])): ?> <!---Dit ziet enkel de admin deze 2 buttons---->
<a class="headerbutton" href="createAdmin.php">Create new admin</a>

<a class="headerbutton" href="statistics.php">Statistics</a>

<?php endif;?>



<!---TAKEN VAN LIJST TONEN------------------------------------------------------------------->

<?php if(isset($_GET['listId'])): ?> 
  <a href="upload.php?listId=<?php echo $_GET['listId'];?>">New Task</a>
  <a href="index.php">Go Back</a>
  
 
  <!---ALLE TAKEN DOORLOPEN---->
  <a href="index.php?listId=<?php echo $_GET['listId'];?>&order=ascending">Sort by hours</a>
  <?php $counter = 0;?>
  <?php foreach($AllTasksForListsAndUser as $Task){ ?> 
  <div class="task">
      <h3><?php echo $Task->getTitle();?></h3>
      <p><?php echo $Task->getHours();?></p>
      <p><?php echo $Task->getDeadline();?></p>
      
      <a href="deleteDeadlineTask.php?taskId=<?php echo $Task->getDeadline();?>">DELETE DEADLINE</a>
      <p class="status"><?php echo $Task->getStatus();?></p>


 

      <p>------</p>
      
      <!---ALLE COMMENTS VAN DE TAAK OVERLOPEN--->
      <div class="comments" data-taskid="<?php echo $Task->getTaskId() ?>" >
     

      <?php foreach(TaskComment::getAllTaskCommentsByTaskId($Task->getTaskId()) as $TaskComment){ ?>
        <p><?php echo $TaskComment->getComment();?></p=>
        
        <?php } ?>
      </div>

<div class="commentBox">
        <input class="commentBoxText" type="text" name="comment">
        <input class="commentBoxButton" type="button" name="submit" data-counter="<?php echo $counter?>" data-taskid="<?php echo $Task->getTaskId() ?>" value="submit">
        <?php $counter = $counter+1?>

</div>


        <a href="#" class="statusDone" data-taskid="<?php echo $Task->getTaskId() ?>">Done</a>

       
      <!---TaskId en listId meegeven met je URL--->
      <a href="deleteTask.php?taskId=<?php echo $Task->getTaskId();?>&listId=<?php echo $_GET['listId'];?>">Delete</a>
     
      

    </div>
    <?php } ?>



  
<?php else: ?>

 
<!---LIJSTEN VAN VAN DE USER TONEN-------------------------------------------------------------------> 



<div class="fullList">
<h2>Alle lijsten</h2>
<div class="AllList">
<div class="newList">
<a href="addlist.php">Add List</a>
</div>
</div>
      </div>



<?php foreach($AllListsForUser as $ListForUser){ ?>
  <div class="infoList">
    <div class="dataList">

      <a href="index.php?listId=<?php echo $ListForUser->getId();?>">
      
        <h3><?php echo $ListForUser->getTitle();?></h3>
        <p><?php echo $ListForUser->getDeadline();?></p>
      </a>
      <p><?php echo $ListForUser->getDescription();?></p>
      

      

      <a href="deleteLists.php?listId=<?php echo $ListForUser->getId();?>">DELETE LIST</a>
      </div>
    </div>
    
    <?php } ?>>

<?php endif; ?>


<script src="js/addComment.js"></script>  
<script src="js/Done.js"></script>  
</body>
</html>

