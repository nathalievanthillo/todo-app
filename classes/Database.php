<?php
    class Database {
        
        private static $conn; //static (eigenschap) en heeft geen instanties= maar 1 uitwerking hebt en bestaande vorm hiervan hebt geen oneindig veel
        
        public static function getConnection(){
            include_once(__DIR__ . "/../settings/settings.php"); //vanuit klasse naar settings willen we settings.php includen 
                                                                //variable DIR bevat het absolute pad naar de folder waar we op dit moment werken 
            
                if(self::$conn === null){
                    self::$conn = new PDO("mysql:host=" . SETTINGS['db']['host'] . ";charset=utf8mb4;dbname=" . SETTINGS['db']['dbName'] , SETTINGS['db']['user'] , SETTINGS['db']['password'] );//hiermee vermijden we dat we per persoon wijzigingen moeten aanbrengen in de klasses
                return self::$conn;
            }else{
                return self::$conn;
            }
            
        }
    }

?>