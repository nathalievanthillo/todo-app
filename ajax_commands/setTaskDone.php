<?php
    include_once(__DIR__ . '/../classes/Task.php');
    include_once(__DIR__ . '/../classes/User.php');

    if(!empty($_POST)){
        session_start();

        $userId = $_SESSION["userId"];  //user_id
        $taskId = $_POST["taskId"]; // post_id
       
          Task::setTaskDone($userId, $taskId);
          Task::setTaskToDo($userId, $taskId);

        $response = [
            "status" => "ok"
        ];
    
        header("Content-Type: application/json");
        echo json_encode($response);
    }
    
    
    ?>