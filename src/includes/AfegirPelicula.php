<?php namespace MyApp\includes;

use MyApp\includes\ConnectionDB as Connection;
use MyApp\includes\PlatformDB as PlatformDB;

class AfegirPelicula
{
    private $connexio;

    public function __construct()
    {
        $this->connexio = Connection::connect();
    }

    function add(Film $film): String
    {
        $release = date('Y', strtotime($film->getRelease()));
        $platform = PlatformDB::getPlatformID($film->getPlatform());

        try {
            $insertMovie = $this->connexio->prepare('INSERT INTO pelicula(titol, sinopsis, valoracio, publicacio, plataforma, caratula)
            VALUES(?,?,?,?)');
            $insertMovie->execute(['titol' => $film->getTitle(), 'sinopsis' => $film->getSinopsis(), 'valoracio' => $film->getRating(), 
                'publicacio' => $release, 'plataforma' => $platform, 'caratula' => $film->getImg()]);
        } catch (PDOException $e) {
            return 'Error, the film couldn\'t be uploaded';
        }
    }
}
