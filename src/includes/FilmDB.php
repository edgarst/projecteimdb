<?php namespace MyApp\includes;
use MyApp\includes\connectionDB as connection;
use MyApp\includes\PlatformDB as platform;
use PDO;
class FilmDB{
    private $connect;

    public function __construct(){
        $this->connect = connection::connect();
    }

    function searchFilm($title)
    {
        $sql = $this->connect->prepare('SELECT * FROM pelicula WHERE titol LIKE :title');
        $sql->execute(['title' => $title]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
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
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($result);
    }

    function filmDirectors($title)
    {
        $directors = json_decode($this->getPersonsID($title, 'director'), true);
        $directorsID = implode(',',$this->fetchPersons($directors, 'director'));

        $sql = $this->connect->prepare("SELECT nom, cognom FROM director WHERE id IN ({$directorsID})");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($result);
    }

    function filmActors($title)
    {
        $actors = json_decode($this->getPersonsID($title, 'actor'), true);
        $actorsID = implode(',',$this->fetchPersons($actors, 'actor'));
        
        $sql = $this->connect->prepare("SELECT nom, cognom FROM actor WHERE id IN ({$actorsID})");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($result);
    }
    
    private function getPersonsID($title, $col)
    {
        $id = json_decode($this->getFilmID($title), true);
        $id = $id[0]['id'];
        $sql = $this->connect->prepare("SELECT id_{$col} FROM pelicula_{$col} WHERE id_pelicula = :id");
        $sql->execute(['id' => $id]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        
        return json_encode($result);
    }

    private function fetchPersons($values, $col)
    {
        $i=0; $info=array();
        foreach ($values as $item) {
            $key = ":id{$i}";
            $info[$key] = $item["id_{$col}"];
            $i++;
        }
        return $info;
    }

    function getFilmID($title)
    {
        $sql = $this->connect->prepare('SELECT id FROM pelicula WHERE titol LIKE :title');
        $sql->execute(['title' => $title]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        
        return json_encode($result);
    }
}
?>