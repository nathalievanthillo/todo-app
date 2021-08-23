<?php

include_once(__DIR__ . '/../classes/TaskComment.php');

if(!empty($_POST)){
    session_start();
    $taskId = $_POST["taskId"]; // post_id


    $commentText = htmlspecialchars($_POST["commentText"]); // text comment

    if (!empty($commentText)) {
        $comment = new TaskComment();
        $comment->setComment($commentText);
        $comment->setTaskId($taskId);
        $comment->SubmitTaskComment();
    }
    
    $response = [
        "status" => "ok"
    ];

    header("Content-Type: application/json");
    echo json_encode($response);
}


?>