<?php namespace MyApp\includes;
use MyApp\includes\connectionDB as connection;
use PDO;
class PlatformDB 
{
    private $connect;

    public function __construct()
    {
        $this->connect = connection::connect();
    }

    function getPlatformID(String $platform): int
    {
        $sql = $this->connect->prepare('SELECT id FROM plataforma WHERE nom LIKE :platform');
        $sql->execute(['platform' => $platform]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        $id = $result[0]['id'];
        return $id;
    }

    function getPlatformName(int $id): String
    {
        $sql = $this->connect->prepare('SELECT nom FROM plataforma WHERE id = :id');
        $sql->execute(['id' => $id]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        $name = $result[0]['nom'];
        return $name;
    }
    
    function getPlatformURL(String $platform): String
    {
        $sql = $this->connect->prepare('SELECT url FROM plataforma WHERE nom LIKE :platform');
        $sql->execute(['platform' => $platform]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        $link = $result[0]['url'];
        return $link;
    }

    function getPlatforms(): Array
    {
        try{
            $sql = $this->connect->prepare('SELECT * FROM plataforma');
            $sql->execute([]);
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        
            $i = 0;
            foreach ($result as $row) {
                $plataforma[$i] = $row['nom'];
                $i++;
            }
            
            return json_encode($plataforma);
        }catch(PDOException $e){
            return "ERROR: {$e->getMessage()}";
        }
    }
}
?>