<?php namespace MyApp\includes\database;
use MyApp\includes\database\ConnectionDB as connection;
use PDO;

class ImageDB
{
    public $connection;

    public function __construct()
    {
        $this->connection = connection::connect();
    }

    function getImages(): json
    {
        try{
            $sql = $this->connection->prepare('SELECT * FROM pelicula');
            $sql->execute(array());
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        
            foreach ($result as $row) {
                array_push($images, $row['caratula']);
            }

            return json_encode($images);
        }catch(PDOException $e){
            return "ERROR: {$e->getMessage()}";
        }
    }

    function getFilmImage($film): json
    {
        try{
            $sql = $this->connection->prepare('SELECT * FROM pelicula WHERE titol LIKE :film');
            $sql->execute(['film' => $film]);
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        
            foreach ($result as $row) {
                $image = $row['caratula'];
            }

            return json_encode($images);
        }catch(PDOException $e){
            return "ERROR: {$e->getMessage()}";
        }
    }
}
?>