<?php namespace MyApp\includes;
use MyApp\includes\connectionDB as CONNECTION;
class GenreDB
{
    private $connect;

    public function __construct()
    {
        $this->connect = CONNECTION::connect();
    }

    function getGenreID($genre)
    {
        $sql = $this->connect->prepare('SELECT id FROM genere WHERE genere LIKE :genere');
        $sql->execute(['genere' => $genre]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($result);
    }

    function getGenres()
    {
        $sql = $this->connect->prepare('SELECT * FROM genere');
        $sql->execute([]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($result);
    }

    function getFilmID($idGenre)
    {
        $sql = $this->connect->prepare('SELECT id_pelicula FROM pelicula_genere WHERE id_genere = :idGenre');
        $sql->execute(['idGenre' => $idGenre]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($result);
    }
}

?>