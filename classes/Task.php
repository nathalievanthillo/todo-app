<?php

include_once(__DIR__ . "/Database.php");


    class Task {
        
        private $taskId;
        private $userId;
        private $listId;
        private $title;
        private $hours;
        private $deadline;
        private $status;
        private $image;

        
        //TASK ID (nummer van de taak)
        public function getTaskId()
        {
                return $this->taskId;
        }

        public function setTaskId($taskId)
        {
                $this->taskId = $taskId;
                return $this;
        }


        
        //USER ID (nummer van user)
        public function getUserId()
        {
                return $this->userId;
        }

        public function setUserId($userId)
        {
                $this->userId = $userId;
        }



        //LIST ID (nummer van de lijst)
        public function getListId()
        {
                return $this->listId;
        }

        public function setListId($listId)
        {
                $this->listId = $listId;
        }



        //TITLE
        public function getTitle()
        {
                return $this->title;
        }

        public function setTitle($title)
        {
                self::checkTitle($title);
                $this->title = $title;
        }



        //HOURS
        public function getHours()
        {
                return $this->hours;
        }

        public function setHours($hours)
        {
                self::sortHours($hours);
                $this->hours = $hours;
        }



        //DEADLINE
        public function getDeadline()
        {
                return $this->deadline;
        }
        
        public function setDeadline($deadline)
        {
                self::checkDeadline($deadline);
                $this->deadline = $deadline;
        }



        //STATUS
        public function getStatus()
        {
                return $this->status;
        }

        public function setStatus($status)
        {
                $this->status = $status;
        }


        

        //IMAGE
        public function setImage($image){ //This is the path you are sending to the database
        //If there is no error, insert the image in the variable
        $this->image = "uploads/" .$image;
        }

        public function getImage(){
            return $this->image;
        }

        
              //CHECK IF TITLE IS NOT EMPTY
              private function checkTitle($title){
                if($title == ""){
                    throw new Exception("Title cannot be empty.");
                }
             }


             public static function sortHours($hours){
                     $conn = Database::getConnection();
                     $statement = $conn->prepare("SELECT * FROM `tasks` WHERE hours = :hours ORDER BY hours ASC");

                     $statement->bindValue(":hours", $hours);
                     $statement->execute();
                     $hours = $statement->fetchAll();

                     return $hours;
             }
    
    
                //CHECK IF TITLE IS NOT EMPTY
                private function checkDeadline($deadline){
                if($deadline == ""){
                    throw new Exception("Deadline cannot be empty.");
                            }
                         }
    
                

            public function submitTask($destinationListId){
                $conn = Database::getConnection();
                $statement = $conn->prepare("INSERT INTO tasks (user_id, list_id, title, hours, deadline, status) VALUES (:userId, :listId, :title, :hours, :deadline, :status)");
            
                $userId     = $this->getUserId();
                $listId     = $destinationListId;
                $title      = $this->getTitle();
                $hours      = $this->getHours();
                $deadline   = $this->getDeadline();
                $status     = "to do";



                $statement->bindValue(":userId", $userId);
                $statement->bindValue(":listId", $listId);
                $statement->bindValue(":title", $title);
                $statement->bindValue(":hours", $hours);
                $statement->bindValue(":deadline", $deadline);
                $statement->bindValue(":status", $status);


                $result = $statement->execute();

            //return resultaat
            return $result;
            }


            //delete je eigen post
            public static function deleteTask($userId, $taskId){
                $conn = Database::getConnection();
                $statement = $conn->prepare("DELETE FROM tasks WHERE id = :taskId and user_id = :user");
                
                $statement->bindValue(":taskId", $taskId);
                $statement->bindValue(":user", $userId);

                $result = $statement->execute();

                //return resultaat
                return $result;
            }

        //delete deadline
            public static function deleteDeadlineTask($userId, $taskId){
                $conn = Database::getConnection();
                $statement = $conn->prepare("DELETE deadline FROM tasks WHERE id = :taskId and user_id = :user");

                $statement->bindValue(":user", $userId);
                $statement->bindValue("taskId", $taskId);

                $result = $statement->execute();
                return $result;
            }


            public static function setTaskDone($userId, $taskId){
                $conn = Database::getConnection();
                $statement = $conn->prepare("UPDATE tasks SET status = 'done' WHERE id = :taskId and user_id = :user");
                
                $statement->bindValue(":taskId", $taskId);
                $statement->bindValue(":user", $userId);


                $result = $statement->execute();

                //return resultaat
                return $result;
            }

            public static function setTaskToDo($userId, $taskId){
                $conn = Database::getConnection();
                $statement = $conn->prepare("UPDATE tasks SET status = 'to do' WHERE id = :taskId and user_id = :user");
                
                $statement->bindValue(":taskId", $taskId);
                $statement->bindValue(":user", $userId);


                $result = $statement->execute();

                //return resultaat
                return $result;
            }
            

            public static function getAllTasksByHours($userId, $listId){
                $conn = Database::getConnection();
                $query = $conn->prepare("SELECT id AS taskId, user_id AS userId, list_id AS listId, title, hours, deadline, status FROM tasks WHERE user_id = :user AND list_id = :list ORDER BY hours ASC"); //of desc

                $query->execute(['user' => $userId, 'list' => $listId]); //user moet vervangen worde ndoor userId en list door listId
               
        
                //return resultaat
                $allTasks = $query->fetchAll(PDO::FETCH_CLASS, "Task" );
                
                return $allTasks;
            }


            public static function getAllTasksByUserAndListId($userId, $listId){ //voor welke user en voor welke lijst de tasks opgehaald moeten worden
                $conn = Database::getConnection();
                $query = $conn->prepare("SELECT id AS taskId, user_id AS userId, list_id AS listId, title, hours, deadline, status FROM tasks WHERE user_id = :user AND list_id = :list ORDER BY deadline ASC"); //of desc

                $query->execute(['user' => $userId, 'list' => $listId]); //user moet vervangen worde ndoor userId en list door listId
               
        
                //return resultaat
                $allTasks = $query->fetchAll(PDO::FETCH_CLASS, "Task" );
                
                return $allTasks;
            }
    }

?>
