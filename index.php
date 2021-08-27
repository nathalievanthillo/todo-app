<?php

include_once(__DIR__ . '/classes/Lists.php');
include_once(__DIR__ . '/classes/Task.php');
include_once(__DIR__ . '/classes/TaskComment.php');
include_once(__DIR__ . '/classes/User.php');

    session_start(); 


  $AllListsForUser[] = NULL; //declareren van de variable
  $AllTasksForListsAndUser[] = NULL;

    //isset is = bestaat die variable
    if(isset($_SESSION['username'])){   
        //user is logged in
        //echo "Welcome " . $_SESSION['username'];
        //queries



        if(!isset($_GET['listId'])){ 
         
            $AllListsForUser = Lists::getAllListsByUserId($_SESSION['userId']); 
          

          
        } else {
          

          if(isset($_GET['order'])){

            $AllTasksForListsAndUser = Task::getAllTasksByHours($_SESSION['userId'], $_GET['listId']);

          }else{

            $AllTasksForListsAndUser = Task::getAllTasksByUserAndListId($_SESSION['userId'], $_GET['listId']); 
          }
          }


    }else{
        //user is not logged in
        header("location: login.php"); 
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
      <?php if(isset($_SESSION['username'])): ?> 
      <h3 class="user--name"><?php echo (htmlspecialchars($_SESSION['username'])); ?></h3>
      <?php else: ?> 
      <h3 class="user--name">Username here</h3>
      <?php endif; ?>

    </a>
    <a href="logout.php">Log out</a>

    
  </nav>    
</header>

<?php if(User::IsAdmin($_SESSION['userId'])): ?> 
<div class="headerAdmin">
<a class="buttonAdmin" href="createAdmin.php">Create new admin</a>

<a class="buttonAdmin" href="statistics.php">Statistics</a>
</div>

<?php endif;?>



<!---TAKEN VAN LIJST TONEN------------------------------------------------------------------->
<div class="navigationTask">
<?php if(isset($_GET['listId'])): ?> 
  <a href="upload.php?listId=<?php echo $_GET['listId'];?>">New Task</a>
  <a href="index.php">Go Back</a>
  
 
  <!---ALLE TAKEN DOORLOPEN---->
  <a href="index.php?listId=<?php echo $_GET['listId'];?>&order=ascending">Sort by hours</a>
  <?php $counter = 0;?>
  <?php foreach($AllTasksForListsAndUser as $Task){ ?> 
  <div class="task">
    <div class="dataTask">
      <h3><?php echo (htmlspecialchars($Task->getTitle()));?></h3>
      <div class="hour">
        <h4>Hours</h4>
      <p><?php echo (htmlspecialchars($Task->getHours()));?></p>
      </div>

      <div class="deadline">
        <h4>Deadline</h4>
      <p><?php echo (htmlspecialchars($Task->getDeadline()));?></p>
      </div>
      
      
      <div class="statusTask">
        <h4>Status</h4>
      <p class="status"><?php echo $Task->getStatus();?></p>
  </div>
</div>

 

      
      <!---ALLE COMMENTS VAN DE TAAK OVERLOPEN--->’
      <div class="comments" data-taskid="<?php echo $Task->getTaskId() ?>" >
     

      <?php foreach(TaskComment::getAllTaskCommentsByTaskId($Task->getTaskId()) as $TaskComment){ ?>
        <p><?php echo (htmlspecialchars($TaskComment->getComment()));?></p=>
        
        <?php } ?>
      </div>

<div class="commentBox">
        <input class="commentBoxText" type="text" name="comment">
        <input class="commentBoxButton" type="button" name="submit" data-counter="<?php echo $counter?>" data-taskid="<?php echo $Task->getTaskId() ?>" value="submit">
        <?php $counter = $counter+1?>

</div>


        <a href="#" class="statusDone" data-taskid="<?php echo $Task->getTaskId() ?>">Done</a>

       
      <!---TaskId en listId meegeven met je URL--->
      <a href="deleteTask.php?taskId=<?php echo $Task->getTaskId();?>&listId=<?php echo $_GET['listId'];?>" class="deleteButton">Delete</a>
     
      </div>

    </div>
    <?php } ?>



    
  
<?php else: ?>

 
<!---LIJSTEN VAN VAN DE USER TONEN-------------------------------------------------------------------> 



<div class="fullList">
<h2>All lists</h2>
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
      
        <h3><?php echo (htmlspecialchars($ListForUser->getTitle()));?></h3>
        <p><?php echo (htmlspecialchars($ListForUser->getDeadline()));?></p>
      </a>
      <p><?php echo (htmlspecialchars($ListForUser->getDescription()));?></p>
      

      
<div class="deleteList">
      <a href="deleteLists.php?listId=<?php echo $ListForUser->getId();?>">DELETE LIST</a>
      </div>
      </div>
    </div>
    
    <?php } ?>

<?php endif; ?>


<script src="js/addComment.js"></script>  
<script src="js/Done.js"></script>  
</body>
</html>

