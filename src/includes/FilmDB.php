<?php namespace MyApp\includes;

use MyApp\includes\ConnectionDB as Connection;
use MyApp\includes\PlatformDB as Platform;
use MyApp\includes\GenreDB as Genre;
use MyApp\includes\Film as Film;
use PDO;

class FilmDB
{
    private $connect;

    public function __construct()
    {
        $this->connect = Connection::connect();
    }

    function searchFilm(String $title): String
    {
        $sql = $this->connect->prepare('SELECT * FROM pelicula WHERE titol LIKE ?');
        $sql->execute(["%{$title}%"]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($result);
    }

    function insertFilm(Film $film): void
    {
        $release = date('Y', strtotime($film->getRelease()));
        $platform = Platform::getPlatformID($film->getPlatform());

        $insert = $this->connect->prepare('INSERT INTO pelicula(titol, sinopsis, valoracio, publicacio, plataforma, caratula)
        VALUES (?,?,?,?,?,?)');

        $insert->execute(['titol' => $film->getTitle(), 'sinopsis' => $film->getSinopsis(), 'valoracio' => $film->getRating(), 
            'publicacio' => $release, 'plataforma' => $platform, 'caratula' => $film->getImg()]);
    }

    function getFilms(): String
    {
        $sql = $this->connect->prepare('SELECT * FROM pelicula');
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($result);
    }

    function filmDirectors(String $title): String
    {
        $directors = json_decode($this->_getPersonsID($title, 'director'), true);
        $directorsID = implode(',',$this->_fetchPersons($directors, 'director'));

        $sql = $this->connect->prepare("SELECT nom, cognom FROM director WHERE id IN ({$directorsID})");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($result);
    }

    function filmActors(String $title): String
    {
        $actors = json_decode($this->_getPersonsID($title, 'actor'), true);
        $actorsID = implode(',',$this->_fetchPersons($actors, 'actor'));
        
        $sql = $this->connect->prepare("SELECT nom, cognom FROM actor WHERE id IN ({$actorsID})");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($result);
    }
    
    private function _getPersonsID(String $title, String $col): String
    {
        $id = json_decode($this->getFilmID($title), true);
        $id = $id[0]['id'];
        $sql = $this->connect->prepare("SELECT id_{$col} FROM pelicula_{$col} WHERE id_pelicula = :id");
        $sql->execute(['id' => $id]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        
        return json_encode($result);
    }

    private function _fetchPersons(Array $values, String $col): Array
    {
        $i = 0; $info = [];

        foreach ($values as $key => $item) {
            $info[$key] = $item["id_{$col}"];
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
        try {
            $sql = $this->connect->prepare('SELECT * FROM pelicula WHERE id = :id');
            $sql->execute(['id' => $id]);
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($result);
        } catch (PDOException $ex) {
            return "ERROR: {$ex->getMessage()}";
        }
    }

    function getFilmsByGenre(String $genre): String
    {
        $genreDB = new Genre();
        $genreID = json_decode($genreDB->getGenreID($genre), true);
        $films = json_decode($genreDB->getFilmID($genreID[0]['id']), true);
        $filmsID = implode(',', $this->fetchPersons($films, 'pelicula'));

        try{
            $sql = $this->connect->prepare("SELECT titol FROM pelicula WHERE id IN ({$filmsID})");
            $sql->execute([]);
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($result);
        } catch (PDOException $ex){
            return "ERROR: {$ex->getMessage()}";
        }
    }
}