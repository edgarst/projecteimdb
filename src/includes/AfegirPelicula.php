<?php namespace MyApp\includes;
use MyApp\includes\connectionDB as connection;
class AfegirPelicula{
    private $film;
    private $connexio;

    public function __construct($title, $sinopsis, $valoracio, $publicacio){
        $this->title = $title;
        $this->sinopsis = $sinopsis;
        $this->valoracio = $valoracio;
        $this->publicacio = $publicacio;
        $this->connexio = ConnectionDB::connect();
    }

    function add($film){
        $title = $film->getTitle();
        $sinopsis = $film->getSinopsis();
        $rating = $film->getRating();
        $release = $film->getRelease();
        $release = date('Y', strtotime($release));
        $img = $film->getImg();
        $platform = $film->getPlatform();
        $platform = PlatformDB::getPlatformID($platform);

        try {
            $insertMovie = $this->connexio->prepare("INSERT INTO pelicula(titol, sinopsis, valoracio, publicacio, plataforma, caratula)
            VALUES(?,?,?,?)");
            $insertMovie->execute(array($title,$sinopsis,$valoracio,$release,$platform, $img));
            echo "Pelicula insertada correctament :D";
        } catch (PDOException $e) {
            echo "Error, no s'ha pogut insertar la pelicula";
        }
    }
}
?>