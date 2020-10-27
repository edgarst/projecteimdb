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

    function insertPersons(Array $persons, int $idFilm, String $table): void
    {
        foreach ($persons as $valuePerson) {
            $valuePerson = trim($valuePerson);
            $idPerson = $this->getPersonID($valuePerson, $table);
            if ($idPerson<1) {
                $this->newPerson($valuePerson, $table);
                $idPerson = $this->getPersonID($valuePerson, $table);
            }
            $this->insertPersonFilm($idPerson, $idFilm, $table);
        }
    }

    private function getPersonID(String $person, String $table): int
    {
        $personName = explode(' ', $person);
        $sql = $this->connect->prepare("SELECT id FROM {$table} WHERE nom LIKE :nom AND cognom LIKE :cognom");
        $sql->execute(['nom' => $personName[0], 'cognom' => $personName[1]]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $this->getID($result);
    }

    private function getID(Array $result): int
    {
        if (empty($result)) return -1;
        
        return intval($result[0]['id']);
    }

    private function newPerson(String $person, String $table): void
    {
        $personName = explode(' ', $person);

        $insert = $this->connect->prepare("INSERT INTO {$table}(nom, cognom) VALUES (?,?)");
        $insert->execute([$personName[0], $personName[1]]);
    }

    private function insertPersonFilm(int $idPerson, int $idFilm, String $table): void
    {
        $insert = $this->connect->prepare("INSERT INTO pelicula_{$table}(id_pelicula, id_{$table}) 
        VALUES (?,?)");
        $insert->execute([$idFilm, $idPerson]);
    }
}


?>