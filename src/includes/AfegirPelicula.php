<?php namespace MyApp\includes;
use MyApp\includes\ConnectionDB as CONNECTION;
use MyApp\includes\PlatformDB as PLATFORMDB;
class AfegirPelicula
{
    private $connexio;

    public function __construct()
    {
        $this->connexio = CONNECTION::connect();
    }

    function add(FILM $film): String
    {
        $release = date('Y', strtotime($film->getRelease()));
        $platform = PLATFORMDB::getPlatformID($film->getPlatform());

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
?>