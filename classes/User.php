<?php

    include_once(__DIR__ . "/Database.php");


    class User{

        private $userId;
        private $username;
        private $password;
        private $email;

        //Username
        const MIN_USERNAME = 5;     //Minimum aantal karakters voor een username
        const MAX_USERNAME = 25;    //Maximum aantal karakters voor een username


        //Password
        const MIN_PASSWORD = 5;     //Minimum aantal karakters voor wachtwoord
        const MAX_PASSWORD = 200;   //Maximum aantal karakters voor wachtwoord


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

        //CHECKS VOOR USERNAME
        private function checkUsername($username){
            if($username == ""){
                throw new Exception("Username cannot be empty."); //veldje username mag niet leeg zijn
            }

            if(strpos($username, " ")){
                throw new Exception("Username cannot contain blank spaces."); //geen witruimtes
            }

            if(strlen($username) < self::MIN_USERNAME){
                throw new Exception("Usernames must be at least" . self::MIN_USERNAME ." characters long"); //username moet minstens 5 karakters hebben
            }

            if(strlen($username) > self::MAX_USERNAME){
                throw new Exception("Username can only be ". self::MAX_USERNAME . " characters long"); //username mag maar max 25 karakters hebben
            }

            if($this->usernameExist($username)){
                throw new Exception("This username is already taken.");
            }
        }

        private function usernameExist($username){
            $conn = Database::getConnection();
            $statement = $conn->prepare("SELECT id FROM users WHERE username = :username");

            $statement->bindValue(":username", $username);
            $statement->execute();
            $result = $statement->fetch();

            if(!$result){ //wanneer username niet gelijk is aan het resultaat
                return false;
            } else {
                return true;
            }
        }
    


        //CHECKS VOOR WACHTWOORD
        public function checkPassword($password){
            if($password == ""){
                throw new Exception("Password cannot be empty!"); //passwoord veldje mag niet leeg zijn
            }

            if(strpos($password, " ")){ 
                throw new Exception("Password cannot contain blank spaces."); //geen lege ruimtes
            }

            if(strlen($password) < self::MIN_PASSWORD){
                throw new Exception("Password must be at least ". self::MIN_PASSWORD ." characters."); //Passwoord moet minstens 5 karakters hebben
            }

            if(strlen($password) > self::MAX_PASSWORD){ 
                throw new Exception("Password can only be ". self::MAX_PASSWORD ." characters long."); //paswoord mag maximum 200 karakters hebben 

        }
    }


        //CHECKS VOOR EMAIL
        private function checkEmail($email){
            if(empty($email)){
                throw new Exception("Email cannot be empty.");
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
            $query = $conn->prepare("SELECT id FROM users WHERE email = :email");

            $query->bindValue(":email", $email);            
            $query->execute();
            $result = $query->fetch();

            if(!$result){
                return False;
            } else {
                //return false if the result is the users own mail
                if (!empty($this->userId)) {
                    if ($result['id'] == $this->userId) { //wanneer het mailadres het zelfde is als een mailadres van een andere userId
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


    }
?>
