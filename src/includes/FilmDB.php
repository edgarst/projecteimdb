<?php namespace MyApp\includes;
use MyApp\includes\connectionDB as CONNECTION;
use MyApp\includes\PlatformDB as PLATFORM;
use MyApp\includes\GenreDB as GENRE;
use MyApp\includes\Film as FILM;
use PDO;
class FilmDB
{
    private $connect;

    public function __construct()
    {
        $this->connect = CONNECTION::connect();
    }

    function searchFilm(String $title): json
    {
        $sql = $this->connect->prepare('SELECT * FROM pelicula WHERE titol LIKE ?');
        $sql->execute(["{$title}%"]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($result);
    }

    function insertFilm(FILM $film)
    {
        $release = date('Y', strtotime($film->getRelease()));
        $platform = PLATFORM::getPlatformID($film->getPlatform());

        $insert = $this->connect->prepare('INSERT INTO pelicula(titol, sinopsis, valoracio, publicacio, plataforma, caratula)
        VALUES (?,?,?,?,?,?)');

        $insert->execute(['titol' => $film->getTitle(), 'sinopsis' => $film->getSinopsis(), 'valoracio' => $film->getRating(), 
            'publicacio' => $release, 'plataforma' => $platform, 'caratula' => $film->getImg()]);
    }

    function getFilms(): json
    {
        $sql = $this->connect->prepare('SELECT * FROM pelicula');
        $sql->execute([]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($result);
    }

    function filmDirectors(String $title): json
    {
        $directors = json_decode($this->getPersonsID($title, 'director'), true);
        $directorsID = implode(',',$this->fetchPersons($directors, 'director'));

        $sql = $this->connect->prepare("SELECT nom, cognom FROM director WHERE id IN ({$directorsID})");
        $sql->execute([]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($result);
    }

    function filmActors(String $title): json
    {
        $actors = json_decode($this->getPersonsID($title, 'actor'), true);
        $actorsID = implode(',',$this->fetchPersons($actors, 'actor'));
        
        $sql = $this->connect->prepare("SELECT nom, cognom FROM actor WHERE id IN ({$actorsID})");
        $sql->execute([]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($result);
    }
    
    private function getPersonsID(String $title, String $col): json
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

    function getFilmID(String $title): json
    {
        $sql = $this->connect->prepare('SELECT id FROM pelicula WHERE titol LIKE :title');
        $sql->execute(['title' => $title]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        
        return json_encode($result);
    }

    function getFilmByID(int $id): json
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

    function getFilmsByGenre(String $genre): json
    {
        $genreDB = new GENRE();
        $films = json_decode($genreDB->getFilmID($genreDB->getGenreID($genre)), true);
        $filmsID = implode(',', $this->fetchPersons($films, 'pelicula'));
        var_dump($films);
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