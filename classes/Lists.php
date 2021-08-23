<?php

include_once(__DIR__ . "/Database.php");

    class Lists {
        private $Id;
        private $userId;
        private $title;
        private $description;
        private $deadline;


        public function getId()
        {
                return $this->Id;
        }


        public function setId($Id)
        {
                $this->Id = $Id;
        }

    
        public function getUserId()
        {
                return $this->userId;
        }


        public function setUserId($userId)
        {
                $this->userId = $userId;
        }

      
        public function getTitle()
        {
                return $this->title;
        }

        public function setTitle($title)
        {
                $this->title = $title;
        }

      
        public function getDescription()
        {
                return $this->description;
        }


        public function setDescription($description)
        {
                self::checkDescription($description);
                $this->description = $description;
        }


        private static function checkDescription($description){
                if($description == ""){
                        throw new Exception("Description field cannot be empty");
                }
        }

        
        public static function getAllListsByUserId($userId){ //ALLE LIJSTEN OPVRAGEN VAN EEN SPECIFIEKE USER
                $conn = Database::getConnection();
                $query = $conn->prepare("SELECT id AS Id, user_id AS userId, title, description, deadline FROM lists WHERE user_id = :user");

                $query->execute(['user' => $userId]);
        
                //return resultaat
                $allLists = $query->fetchAll(PDO::FETCH_CLASS, "Lists" );
                
                return $allLists;
            }

            public function AddList(){
                $conn = Database::getConnection();
                $statement = $conn->prepare("INSERT INTO lists (user_id, title, description, deadline) VALUES (:userId, :title, :description, :deadline)");
            
                $userId     = $this->getUserId();
                $title      = $this->getTitle();
                $description  = $this->getDescription(); 
                $deadline   = $this->getDeadline();



                $statement->bindValue(":userId", $userId);
                $statement->bindValue(":title", $title);
                $statement->bindValue(":description", $description);
                $statement->bindValue(":deadline", $deadline);


                $result = $statement->execute();

            //return resultaat
            return $result;
            }


            //delete je eigen lijst
            public static function deleteLists($userId, $listId){
                $conn = Database::getConnection();
                $statement = $conn->prepare("DELETE FROM lists WHERE id = :listsId and user_id = :user");
                
                $statement->bindValue(":listsId", $listsId);
                $statement->bindValue(":user", $userId);

                $result = $statement->execute();

                //return resultaat
                return $result;
            }

        /**
         * Get the value of deadline
         */ 
        public function getDeadline()
        {
                return $this->deadline;
        }


        public function setDeadline($deadline)
        {
                $this->deadline = $deadline;
        }
}
