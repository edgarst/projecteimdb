<?php namespace MyApp\includes;
use MyApp\includes\connectionDB as connection;
class PlatformDB {
    private $connect;

    public function __construct(){
        $this->connect = connection::connect();
    }

    function getPlatformID($platform){
        $sql = $this->connect->prepare('SELECT * FROM plataforma WHERE nom LIKE $platform');
        $sql->execute(array());
        $result = $sql->fetchAll();

        $id = result["id"];
        return $id;
    }

    function getPlatformURL($platform){
        $sql = $this->connect->prepare('SELECT * FROM plataforma WHERE nom LIKE $platform');
        $sql->execute(array());
        $result = $sql->fetchAll();

        $link = result["url"];
        return $link;
    }

    function getPlatforms(){
        try{
            $sql = $this->connect->prepare('SELECT * FROM plataforma');
            $sql->execute(array());
            $result = $sql->fetchAll();
        
            $i = 0;
            foreach ($result as $row) {
                $plataforma[$i] = $row["nom"];
                $i++;
            }
            
            return $plataforma;
        }catch(PDOException $e){
            echo "ERROR: " . $e->getMessage();
        }
    }
}
?>