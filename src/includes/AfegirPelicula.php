<?php namespace MyApp\includes;
use MyApp\includes\ConnectionDB as connection;
use MyApp\includes\PlatformDB as platformDB;
class AfegirPelicula
{
    private $film;
    private $connexio;

    public function __construct($title, $sinopsis, $valoracio, $publicacio)
    {
        $this->title = $title;
        $this->sinopsis = $sinopsis;
        $this->valoracio = $valoracio;
        $this->publicacio = $publicacio;
        $this->connexio = connection::connect();
    }

    function add($film)
    {
        $release = date('Y', strtotime($film->getRelease()));
        $platform = platformDB::getPlatformID($film->getPlatform());

        try {
            $insertMovie = $this->connexio->prepare('INSERT INTO pelicula(titol, sinopsis, valoracio, publicacio, plataforma, caratula)
            VALUES(?,?,?,?)');
            $insertMovie->execute(['titol' => $film->getTitle(), 'sinopsis' => $film->getSinopsis(), 'valoracio' => $film->getRating(), 
                'publicacio' => $release, 'plataforma' => $platform, 'caratula' => $film->getImg()]);
        } catch (PDOException $e) {
            return "Error, no s'ha pogut insertar la pelicula";
        }
    }
}
?>