<?php namespace MyApp\includes\database;
use MyApp\includes\database\ConnectionDB as CONNECTION;
use PDO;

class GenreDB
{
    private $connect;

    public function __construct()
    {
        $this->connect = CONNECTION::connect();
    }

    function getGenreID(String $genre): String
    {
        $sql = $this->connect->prepare('SELECT id FROM genere WHERE genere LIKE :genere');
        $sql->execute(['genere' => $genre]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($result);
    }

    function getGenres(): String
    {
        $sql = $this->connect->prepare('SELECT * FROM genere');
        $sql->execute([]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($result);
    }

    function getFilmID(int $idGenre): String
    {
        $sql = $this->connect->prepare('SELECT id_pelicula FROM pelicula_genere WHERE id_genere = :idGenre');
        $sql->execute(['idGenre' => $idGenre]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($result);
    }

    function insertGenreMovie(String $genre, int $idFilm): void
    {
        $idGenre = $this->decodeGenreID($genre);

        $sql = $this->connect->prepare('INSERT INTO pelicula_genere(id_pelicula, id_genere)
        VALUES (?,?)');
        $sql->execute([$idFilm, $idGenre]);
    }

    function decodeGenreID(String $genre): int
    {
        $idGenre = $this->getGenreID($genre);
        $idGenre = json_decode($idGenre, true);
        return $idGenre[0]['id'];
    }
}

?>