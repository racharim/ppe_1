<?php

class dataBase {

    private static $pdo;
    private static $dbDsn = 'mysql:host=127.0.0.1;dbname=ppe_1;';
    private static $dbUser = 'root';
    private static $dbPass = '';
    
    public static function get():pdo 
    {
        self::$pdo = new PDO(self::$dbDsn,self::$dbUser,self::$dbPass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                   PDO::ATTR_ERRMODE,
                   PDO::ERRMODE_EXCEPTION,
                   PDO::FETCH_ASSOC));
        return self::$pdo;
    }
}

?>