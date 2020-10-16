<?php namespace MyApp\includes\database;

use PDO;

class ConnectionDB {

    public static function connect()
    {
        try{
            $connect = new PDO('mysql:host=localhost;dbname=imdb;charset=utf8', 'root', '');
            $connect ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex){
            echo "ERROR: {$ex->getMessage()}";
        }
        return $connect;
    }
}
