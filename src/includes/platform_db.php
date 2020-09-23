<?php namespace MyApp\includes;
use MyApp\includes\Connection_db as connection;

class Platform_db {
    private $connect;

    public function __construct(){
        $this->connect = connection::connect();
    }

    public static function getPlatformID($platform){
        $sql = $connect->prepare('SELECT * FROM plataforma WHERE nom LIKE $platform');
        $sql->execute(array());
        $result = $sql->fetchAll();

        $id = result["id"];
        return $id;
    }

    public static function getPlatforms(){
        try{
            $sql = $connect->prepare('SELECT * FROM plataforma');
            $sql->execute(array());
            $result = $sql->fetchAll();
        
            $i = 0;
            foreach ($result as $row) {
                $plataforma[$i] = $row["nom"];
                $i++;
            }
            
            return plataforma;
        }catch(PDOException $e){
            echo "ERROR: " . $e->getMessage();
        }
    }
}
?>