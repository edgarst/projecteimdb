<?php namespace MyApp\includes;
use MyApp\includes\database\ConnectionDB as CONNECTION;
use MyApp\includes\database\PlatformDB as PLATFORMDB;
use PDO;

class InsertMovie
{
    private $connection;

    public function __construct()
    {
        $this->connection = CONNECTION::connect();
    }

    function add(Film $film): String
    {
        $platformDB = new PLATFORMDB();
        $release = date('Y', strtotime($film->getRelease()));
        $platform = $platformDB->getPlatformID($film->getPlatform());

        try {
            $insertMovie = $this->connection->prepare('INSERT INTO pelicula(titol, sinopsis, valoracio, publicacio, plataforma, caratula)
            VALUES(?,?,?,?)');
            $insertMovie->execute(['titol' => $film->getTitle(), 'sinopsis' => $film->getSinopsis(), 'valoracio' => $film->getRating(), 
                'publicacio' => $release, 'plataforma' => $platform, 'caratula' => $film->getImg()]);
        } catch (PDOException $e) {
            return 'Error, the film couldn\'t be uploaded';
        }
    }
}
