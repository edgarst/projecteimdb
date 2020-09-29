<<<<<<< HEAD
<?php 
class ConnectionDB{
=======
<?php namespace MyApp\includes;
use PDO;

class ConnectionDB{

>>>>>>> feature/Database_Test
    public static function connect(){
        try{
            $connect = new PDO('mysql:host=localhost;dbname=imdb', 'root', '');
            $connect ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo "ERROR: " . $e->getMessage();
        }
        return $connect;
    }
}
?>