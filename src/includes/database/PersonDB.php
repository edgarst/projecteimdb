<?php namespace MyApp\includes\database;
use MyApp\includes\database\ConnectionDB as CONNECTION;
use PDO;

class PersonDB
{
    private $connect;

    public function __construct()
    {
        $this->connect = CONNECTION::connect();
    }

    function insertActors(Array $actors): void
    {

    }

    function insertDirectors(Array $directors): void
    {
        foreach ($directors as $valueDirector) {

        }
    }

    private function existsDirector(String $director): boolean
    {
        $name;
        $lastname;
        $sql = $this->connect->prepare('SELECT * FROM director WHERE nom LIKE ? AND cognom LIKE ?');
        $sql-execute([]);
    }

    private function newDirector(String $director): void
    {
        $name;
        $lastname;

        $insert = $this->connect->prepare('INSERT INTO director(nom, cognom) VALUES (?,?)');
        $insert->execute([$name, $lastname]);
    }
}


?>