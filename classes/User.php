<?php

    include_once(__DIR__ . "/Database.php");


    class User{

        private $userId;
        private $username;
        private $password;
        private $email;
        private $is_admin;


        public static function canLogin($username, $password){
            //connection
            $conn = Database::getConnection();

            //insert a query
            $statement = $conn->prepare("SELECT * FROM users WHERE username = :username");

            $statement->bindValue(":username", $username);
            $statement->execute();

            $user = $statement->fetch();
            $hash = $user["password"]; 

            if(!$user){
                return false; //foute gebruikersnaam
            }

            if(password_verify($password, $hash)){ //kijkt wachtwoord na in bcrypt
                return true;
            } else {
                return false;
            }
        }


        /**
         * Get the value of userId
         */ 
        public function getUserId()
        {
                return $this->userId;
        }

        /**
         * Set the value of userId
         *
         * @return  self
         */ 
        public function setUserId($userId)
        {
                $this->userId = $userId;

                return $this;
        }


        public static function getUserIdByName($username){
            $conn = Database::getConnection();
            $statement = $conn->prepare("SELECT id FROM users WHERE username = :username");

            $statement->bindValue(":username", $username);
            $statement->execute();
            $result = $statement->fetch();

            return $result['id']; //return het resultaat als een id

        }
        /**
         * Get the value of username
         */ 
        public function getUsername()
        {
                return $this->username;
        }

        public static function getUsernameById($userId){
            $conn = Database::getConnection();
            $statement = $conn->prepare("SELECT username FROM users WHERE id = :userId");
            
            $statement->bindValue(":userId", $userId);
            $statement->execute();
            $username = $statement->fetch();

            return $username["username"];
        }

        /**
         * Set the value of username
         *
         */ 
        public function setUsername($username)
        {
                self::checkUsername($username);
                $this->username = $username;
        }



        /**
         * Get the value of password
         */ 
        public function getPassword()
        {
                return $this->password;
        }

        public static function getPasswordById($userId){
            $conn = Database::getConnection();
            $statement = $conn->prepare("SELECT password FROM users WHERE id = :userId");
            
            $statement->bindValue(":userId, $userId");
            $statement->execute();
            $password = $statement->fetch();

            return $password["password"];
        }

        /**
         * Set the value of password
         *
         */ 
        public function setPassword($password)
        {
               self::checkPassword($password);

               $options = [
                   'cost' => 14,
               ];

               $password = password_hash($_POST['password'], PASSWORD_DEFAULT, $options);
               $this->password = $password;
               return $this;
        }

        /**
         * Get the value of email
         */ 
        public function getEmail()
        {
                return $this->email;
        }

        public static function getEmailById($userId){
            $conn = Database::getConnection();
            $statement = $conn->prepare("SELECT email FROM users WHERE id = :userId");

            $statement->bindValue(":userId", $userId);
            $statement->execute();
            $email = $statement->fetch();
            
            return $email["email"];
        }
        /**
         * Set the value of email
         *
         */ 
        public function setEmail($email)
        {
                self::checkEmail($email);
                $this->email = $email;
        }

        public function getIs_admin()
        {
                return $this->is_admin;
        }
        public function setIs_admin($is_admin)
        {
                $this->is_admin = $is_admin;
        }



        public static function IsAdmin($userId){ //userId geef je mee met isAdmin
            $conn = Database::getConnection();
            $statement = $conn->prepare("SELECT id FROM users WHERE is_admin = 1 AND id = :userId"); 
        
            $statement->bindValue(":userId", $userId);

            $result = $statement->execute();
            $result = $statement->fetch(); 
            
            if(!empty($result)){
                return true;

            } else{

                return false;
            }
        
        }

        
        public static function getUsers($user){
            $conn = Database::getConnection();
            $statement = $conn->prepare("SELECT * FROM users");

            $statement->bindValue(":id", $user->getUserId());
            $statement->execute();

            $result = $statement->fetchAll(\PDO::FETCH_OBJ);
            return $result;
        }


        public static function countUsers(){
            $conn = Database::getConnection();
            $statement = $conn->prepare("SELECT COUNT(*) FROM users");
    
            $statement->execute();

            $result = $statement->fetch(\PDO::FETCH_COLUMN);
           
            return $result; //$return zitten de lijsten van de admins
            
        }




        private function checkUsername($username){
            if($username == ""){
                throw new Exception("Username cannot be empty.");
            }

            if(strpos($username, " ")){
                throw new Exception("Username cannot contain blank spaces.");
            }

            if($this->usernameExists($username)){
                throw new Exception("This username is taken.");
            }
        }

        private function usernameExists($username){ 
            $conn = Database::getConnection();
            $statement = $conn->prepare("SELECT id FROM users WHERE username = :username");

            $statement->bindValue(":username", $username);            
            $statement->execute();
            $result = $statement->fetch();

            if(!$result){
                return False;
            } else {
                return True;
            }
        }
        


        public function checkPassword($password){
            if($password == ""){
                throw new Exception("Password cannot be empty!");
            }

            if(strpos($password, " ")){
                throw new Exception("Password cannot contain blank spaces.");
            }

        }


        private function checkEmail($email){
            if(empty($email)){
                throw new Exception("Email cannot be empty");
            }

            if(!strpos($email, "@") || !strpos($email, ".") || strpos($email, " ") ){
                throw new Exception("Email is invalid");
        }

        if($this->emailExists($email)){
            throw new Exception("This email has already been registered.");
        }
    }

    private function emailExists($email){ 
        $conn = Database::getConnection();
        $statement = $conn->prepare("SELECT id FROM users WHERE email = :email");

        $statement->bindValue(":email", $email);            
        $statement->execute();
        $result = $statement->fetch();

        if(!$result){
            return False;
        } else {
            //Return false if the result is the users own email
            if (!empty($this->userId)) {
                if ($result['id'] == $this->userId) {
                    return False;
                }
            }
            return True;
        }
    }


    
    
    
        public function save(){
            $conn = Database::getConnection();
            $statement = $conn->prepare("INSERT INTO users (username, password, email) VALUES (:username, :password, :email)");
        
            $username = $this->getUsername();
            $password = $this->getPassword();
            $email = $this->getEmail();
            
            $statement->bindValue(":username", $username);
            $statement->bindValue(":password", $password);
            $statement->bindValue(":email", $email);

            $result = $statement->execute();

            //return resultaat
            return $result;
        }


        public function saveAdmin(){
            $conn = Database::getConnection();
            $statement = $conn->prepare("INSERT INTO users (username, password, email, is_admin) VALUES (:username, :password, :email, 1)");
        
            $username = $this->getUsername();
            $password = $this->getPassword();
            $email = $this->getEmail();

            
            $statement->bindValue(":username", $username);
            $statement->bindValue(":password", $password);
            $statement->bindValue(":email", $email);


            $result = $statement->execute();

            //return resultaat
            return $result;

        }



      
    }
?>
