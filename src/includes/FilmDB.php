<?php namespace MyApp\includes;
use MyApp\includes\connectionDB as connection;
use MyApp\includes\PlatformDB as platform;
class FilmDB{
    private $connect;

    public function __construct(){
        $this->connect = connection::connect();
    }

    function searchFilm($title)
    {
        $sql = $this->connect->prepare('SELECT * FROM pelicula WHERE titol LIKE :title');
        $sql->execute(['title' => $title]);
        $result = $sql->fetchAll();
        return json_encode($result);
    }

    function insertFilm($film)
    {
        $release = date('Y', strtotime($film->getRelease()));
        $platform = platform::getPlatformID($film->getPlatform());

        $insert = $this->connect->prepare('INSERT INTO pelicula(titol, sinopsis, valoracio, publicacio, plataforma, caratula)
        VALUES (?,?,?,?,?,?)');

        $insert->execute(['titol' => $film->getTitle(), 'sinopsis' => $film->getSinopsis(), 'valoracio' => $film->getRating(), 
            'publicacio' => $release, 'plataforma' => $platform, 'caratula' => $film->getImg()]);
    }

    function getFilms()
    {
        $sql = $this->connect->prepare('SELECT * FROM pelicula');
        $sql->execute([]);
        $result = $sql->fetchAll();

        return json_encode($result);
    }

    function filmDirectors($title)
    {
        $directors = $this->getDirectorsID($title);
        $directorsID = $this->fetchDirectors($directors);
        $sql = $this->connect->prepare('SELECT nom, cognom FROM director WHERE id IN :directorsID');
        $sql->execute([$directorsID]);
        $result = $sql->fetchAll();

        return json_encode($result);
    }
    
    private function getDirectorsID($title)
    {
        $id = $this->getFilmID($title);
        $sql = $this->connect->prepare('SELECT id_director FROM pelicula_director WHERE id_pelicula = :id');
        $sql->execute(['id' => $id]);
        $result = $sql->fetchAll();

        return json_encode($result);
    }

    private function fetchDirectors($directors)
    {
        $i=0;
        foreach ($directors as $item) {
            $item += $directors[$i]['id_director'];
            $i++;
        }
        $item = rtrim($item,",");
        return $item;
    }

    function getFilmID($title)
    {
        $sql = $this->connect->prepare('SELECT id FROM pelicula WHERE titol LIKE :title');
        $sql->execute(['title' => $title]);
        $result = $sql->fetchAll();

        return json_encode($result);
    }

}
?>