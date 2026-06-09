<?php

class dataBase {

    private static $pdo;
    private static $dbDsn = 'mysql:host=172.22.100.17;dbname=ppe1_alexis;';
    private static $dbUser = 'alexis';
    private static $dbPass = 'Bonjour123!';
    
    public static function get():pdo 
    {
        self::$pdo = new PDO(self::$dbDsn,self::$dbUser,self::$dbPass, array(
                   PDO::ATTR_ERRMODE,
                   PDO::ERRMODE_EXCEPTION,
                   PDO::FETCH_ASSOC));
        return self::$pdo;
    }
}

?>