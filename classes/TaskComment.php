<?php

include_once(__DIR__ . "/Database.php");

class TaskComment{

    private $taskCommentId;
    private $taskId;
    private $comment;




    public function getTaskCommentId()
    {
        return $this->taskCommentId;
    }
    

    public function setTaskCommentId($taskCommentId)
    {
        $this->taskCommentId = $taskCommentId;
        return $this;
    }


    public function getTaskId()
    {
        return $this->taskId;
    }

    public function setTaskId($taskId)
    {
        $this->taskId = $taskId;
    }

  
    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }




    public static function getAllTaskCommentsByTaskId($taskId){
        $conn = Database::getConnection();
        $query = $conn->prepare("SELECT id AS taskCommentId, task_id AS taskId, comment FROM task_comments WHERE task_id = :task");

        $query->execute(['task' => $taskId]);

        //return resultaat
        $taskComments = $query->fetchAll(PDO::FETCH_CLASS, "TaskComment" );
        
        return $taskComments;
    }


    public function SubmitTaskComment(){
        $conn = Database::getConnection();
        $statement = $conn->prepare("INSERT INTO task_comments (task_id, comment) VALUES (:taskId, :comment)");
    
        $comment     = $this->getComment();
        $taskId      = $this->getTaskId();
    
        $statement->bindValue(":taskId", $taskId);
        $statement->bindValue(":comment", $comment);

        $result = $statement->execute();
    //return resultaat
    return $result;
    }



}



?>