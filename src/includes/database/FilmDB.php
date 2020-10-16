<?php namespace MyApp\includes\database;
use MyApp\includes\database\connectionDB as CONNECTION;
use MyApp\includes\database\PlatformDB as PLATFORM;
use MyApp\includes\database\GenreDB as GENRE;
use MyApp\includes\Film as FILM;
use PDO;

class FilmDB
{
    private $connect;
    private $film;

    public function __construct(FILM $film)
    {
        $this->connect = CONNECTION::connect();
        $this->film = $film;
    }

    function searchFilm(String $title): String
    {
        $sql = $this->connect->prepare('SELECT * FROM pelicula WHERE titol LIKE ?');
        $sql->execute(["%{$title}%"]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($result);
    }

    function insertFilm(): void
    {
        $platformDB = new PLATFORM();
        $platform = $platformDB->getPlatformID($this->film->getPlatform());
        $release = date('Y', strtotime($film->getRelease()));

        $insert = $this->connect->prepare('INSERT INTO pelicula(titol, sinopsis, valoracio, publicacio, plataforma, caratula)
        VALUES (?,?,?,?,?,?)');

        $insert->execute(['titol' => $this->ilm->getTitle(), 'sinopsis' => $this->film->getSinopsis(), 'valoracio' => $this->film->getRating(), 
            'publicacio' => $this->release, 'plataforma' => $this->platform, 'caratula' => $this->film->getImg()]);
    }

    function getFilms(): String
    {
        $sql = $this->connect->prepare('SELECT * FROM pelicula');
        $sql->execute([]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($result);
    }

    function filmDirectors(): String
    {
        $directors = json_decode($this->getPersonsID($this->film->getTitle(), 'director'), true);
        $directorsID = implode(',',$this->fetchPersons($directors, 'director'));

        $sql = $this->connect->prepare("SELECT nom, cognom FROM director WHERE id IN ({$directorsID})");
        $sql->execute([]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($result);
    }

    function filmActors(): String
    {
        $actors = json_decode($this->getPersonsID($this->film->getTitle(), 'actor'), true);
        $actorsID = implode(',',$this->fetchPersons($actors, 'actor'));
        
        $sql = $this->connect->prepare("SELECT nom, cognom FROM actor WHERE id IN ({$actorsID})");
        $sql->execute([]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($result);
    }
    
    private function getPersonsID(String $title, String $col): String
    {
        $id = json_decode($this->getFilmID($title), true);
        $id = $id[0]['id'];
        $sql = $this->connect->prepare("SELECT id_{$col} FROM pelicula_{$col} WHERE id_pelicula = :id");
        $sql->execute(['id' => $id]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        
        return json_encode($result);
    }

    private function fetchPersons(Array $values, String $col): Array
    {
        $i=0; $info=array();
        foreach ($values as $item) {
            $key = ":id{$i}";
            $info[$key] = $item["id_{$col}"];
            $i++;
        }
        return $info;
    }

    function getFilmID(String $title): String
    {
        $sql = $this->connect->prepare('SELECT id FROM pelicula WHERE titol LIKE :title');
        $sql->execute(['title' => $title]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        
        return json_encode($result);
    }

    function getFilmByID(int $id): String
    {
        try{
            $sql = $this->connect->prepare('SELECT * FROM pelicula WHERE id = :id');
            $sql->execute(['id' => $id]);
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($result);
        }catch(PDOException $e){
            return "ERROR: {$e->getMessage()}";
        }
    }

    function getFilmsByGenre(String $genre): String
    {
        $genreDB = new GENRE();
        $genreID = json_decode($genreDB->getGenreID($genre), true);
        $films = json_decode($genreDB->getFilmID($genreID[0]['id']), true);
        $filmsID = implode(',', $this->fetchPersons($films, 'pelicula'));
        try{
            $sql = $this->connect->prepare("SELECT titol FROM pelicula WHERE id IN ({$filmsID})");
            $sql->execute([]);
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($result);
        }catch(PDOException $e){
            return "ERROR: {$e->getMessage()}";
        }
    }
}
?>