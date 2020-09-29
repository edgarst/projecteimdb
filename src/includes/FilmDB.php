<?php namespace MyApp\includes;
use MyApp\includes\connectionDB as connection;
use MyApp\includes\PlatformDB as platform;
class FilmDB{
    private $connect;

    public function __construct(){
        $this->connect = connection::connect();
    }

    function searchFilm($title){
        $sql = $this->connect->prepare('SELECT * FROM pelicula WHERE titol LIKE $title');
        $sql->execute(array());
        $result = $sql->fetchAll();

        return $result;
    }

    function insertFilm($film){
        $title = $film->getTitle();
        $sinopsis = $film->getSinopsis();
        $rating = $film->getRating();
        $release = $film->getRelease();
        $release = date('Y', strtotime($release));
        $img = $film->getImg();
        $platform = $film->getPlatform();
        $platform = platform::getPlatformID($platform);

        $sql = "INSERT INTO pelicula(titol, sinopsis, valoracio, publicacio, plataforma, caratula)
        VALUES ($title, $sinopsis, $rating, $release, $platform, $img)";

        $insert = $this->connect->prepare("INSERT INTO pelicula(titol, sinopsis, valoracio, publicacio, plataforma, caratula)
        VALUES (?,?,?,?,?,?)");

        $insert->execute($title, $sinopsis, $rating, $release, $platform, $img);
    }

    function getFilms(){
        $sql = $this->connect->prepare('SELECT * FROM pelicula');
        $sql->execute(array());
        $result = $sql->fetchAll();

        return $result;
    }
}
?>