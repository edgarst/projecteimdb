<?php namespace MyApp\includes;
use MyApp\includes\ConnectionDB as connection;

class ImageDB{
    public $connection;

    public function __construct(){
        $this->connection = connection::connect();
    }

    function getImages(){
        try{
            $sql = $this->connection->prepare('SELECT * FROM pelicula');
            $sql->execute(array());
            $result = $sql->fetchAll();
        
            $i = 0;
            foreach ($result as $row) {
                $images[$i] = $row["caratula"];
                $i++;
            }

            return $images;
        }catch(PDOException $e){
            echo "ERROR: " . $e->getMessage();
        }
    }

    function getFilmImage($film){
        try{
            $sql = $this->connection->prepare("SELECT * FROM pelicula WHERE titol LIKE ".$film);
            $sql->execute(array());
            $result = $sql->fetchAll();
        
            $i = 0;
            foreach ($result as $row) {
                $images[$i] = $row["caratula"];
                $i++;
            }

            return $images;
        }catch(PDOException $e){
            echo "ERROR: " . $e->getMessage();
        }
    }
}


?>