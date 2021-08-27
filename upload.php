<?php

    include_once(__DIR__ . '/classes/Task.php');
    include_once(__DIR__ . '/classes/Lists.php');

    session_start();

    if(!empty($_POST)){
        
  
        try{
          $fileName = "";

              $fileTmpName = $_FILES["fileToUpload"]["tmp_name"];
              if($_FILES["fileToUpload"]["type"] == "image/png"){
                $fileName = $_SESSION['username']."task".date("YmdHis").".png";

              } elseif ($_FILES["fileToUpload"]["type"] == "application/pdf"){ 
                
                $fileName = $_SESSION['username']."task".date("YmdHis").".pdf";

              }
                else{
                  $error = "file type niet geldig";
                }
            

                $task = new Task();
                $task->setUserId($_SESSION['userId']);

                if($_FILES['fileToUpload']['name'] == ""){
                  $fileName = "";
                }
    
                $task->setImage($fileName);
                $task->setTitle($_POST["title"]);
                $task->setHours($_POST["hours"]);
                $task->setDeadline($_POST["deadline"]);
    
                $task->submitTask($_GET['listId']);
                header('location: index.php?listId='.$_GET['listId']);

                $uploads_directory = 'uploads/';
                move_uploaded_file($fileTmpName, "uploads/" .$fileName); //fileToUpload -> /uploads -> fileName

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
    <title>Upload task</title>
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
    

<form action="upload.php?listId=<?php echo $_GET['listId'];?>" method="post" enctype="multipart/form-data">
    <h2>TODO - APP</h2>

  <div class="form form--task">

    
    <label for="fileToUpload">Upload file</label>
    <input type = "file" name = "fileToUpload"/></br> 

    <label for="title">Title</label>
    <input type="text" id="title" name="title">


    <label for="hours">Hours</label>
    <input type="text" id="hours" name="hours">

    <label for="deadline">Deadline</label>
    <input type="text" id="deadline" name="deadline">

    <button type="submit" name="btnSubmit" class="submitNewTask">Add Task</button>
    <input type="reset" value="Reset">


    <?php if(isset($error)): ?>
    <div class="alert">
      <?php echo $error;?></div>
    <?php endif; ?>

  </div>
</form>

</body>
</html>
