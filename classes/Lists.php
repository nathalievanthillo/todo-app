<?php

include_once(__DIR__ . "/Database.php");

    class Lists {
        private $Id;
        private $userId;
        private $title;
        private $description;
        private $deadline;

        public function getId(){
            return $this->Id;
        }


        public function setId($Id){
            $this->Id = $Id;
        }

    
        public function getUserId(){
            return $this->userId;
        }


        public function setUserId($userId){
            $this->userId = $userId;
        }

      
        public function getTitle(){
            return $this->title;
        }

        public function setTitle($title){
            $this->title = $title;
        }

      
        public function getDescription(){
            return $this->description;
        }


        public function setDescription($description){
            self::checkDescription($description);
            $this->description = $description;
        }


        private static function checkDescription($description){
            if($description == ""){
                    throw new Exception("Description field cannot be empty");
            }
        }

        
        public static function getAllListsByUserId($userId){ 
            $conn = Database::getConnection();
            $query = $conn->prepare("SELECT id AS Id, user_id AS userId, title, description, deadline FROM lists WHERE user_id = :user ORDER BY deadline ASC");

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

        public function getDeadline(){
                return $this->deadline;
            }
    
            public function setDeadline($deadline){
                $this->deadline = $deadline;
            }


            public static function getLists($user){
                $conn = Database::getConnection();
                $statement = $conn->prepare("SELECT * FROM lists WHERE user_id = :id");
                $statement->bindValue(":id", $user->getUserId());
                $statement->execute();
                $result = $statement->fetchAll(\PDO::FETCH_OBJ);
                return $result;
            }

            public static function countLists(){
                $conn = Database::getConnection();
                $statement = $conn->prepare("SELECT COUNT(*) FROM lists");
    
                $statement->execute();
                $result = $statement->fetch(\PDO::FETCH_COLUMN);
                return $result;
            }
            

        //delete je eigen lijst
       
       public static function deleteLists($userId, $listId){
        $conn = Database::getConnection();
        $statement = $conn->prepare("DELETE FROM lists WHERE id = :listsId and user_id = :user");

        $statement->bindValue(":listsId", $listId);
        $statement->bindValue(":user", $userId);

        $result = $statement->execute();

        $conn = Database::getConnection();
        $statement = $conn->prepare("DELETE FROM tasks WHERE list_id = :listId");

        $statement->bindValue(":listId", $listId);

        $result = $statement->execute();

        //return resultaat
        return $result;
    }



       
}
