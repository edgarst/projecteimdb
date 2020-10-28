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

            if ($idPerson === -1) {
                $this->newPerson($valuePerson, $table);
                $idPerson = $this->getPersonID($valuePerson, $table);
            }

            $this->insertPersonFilm($idPerson, $idFilm, $table);
        }
    }

    private function getPersonID(String $person, String $table): int
    {
        $personName = explode(' ', $person);

        if(count($personName) === 1) return $this->getPersonIdOnlyName($name[0], $table);

        $name = $this->getPersonName($personName);
        
        if($table === 'actor') return $this->getActorID($personName);
        
        return $this->getDirectorID($personName);
    }

    private function getPersonIdOnlyName(String $name, String $table): int
    {
        if($table === 'actor') return $this->getActorIdOnlyName($name);
        
        return $this->getDirectorIdOnlyName($name);
    }

    private function getActorIdOnlyName(String $name): int
    {
        $sql = $this->connect->prepare('SELECT id FROM actor WHERE nom LIKE ? ORDER BY id DESC LIMIT 1'); // If there are 2 actors with same name will take the recent one
        $sql->execute([$name]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $this->getID($result);
    }

    private function getDirectorIdOnlyName(String $name): int
    {
        $sql = $this->connect->prepare('SELECT id FROM director WHERE nom LIKE ? ORDER BY id DESC LIMIT 1'); // If there are 2 directors with same name will take the recent one
        $sql->execute([$name]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $this->getID($result);
    }

    private function getActorID(Array $name): int
    {
        $sql = $this->connect->prepare('SELECT id FROM actor WHERE nom LIKE :nom AND cognom LIKE :cognom');
        $sql->execute(['nom' => $name[0], 'cognom' => $name[1]]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $this->getID($result);
    }

    private function getDirectorID(Array $name): int
    {
        $sql = $this->connect->prepare('SELECT id FROM director WHERE nom LIKE :nom AND cognom LIKE :cognom');
        $sql->execute(['nom' => $name[0], 'cognom' => $name[1]]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $this->getID($result);
    }

    private function getPersonName(Array $person): Array
    {
        $personName = [];
        $personName[0] = $person[0];

        $person = array_splice($person, 0, 1);
        $lastname = implode(' ', $person);
        $personName[1] = $lastname;

        return $personName;
    }

    private function getID(Array $result): int
    {
        if (empty($result)) return -1;
        
        return intval($result[0]['id']);
    }

    private function newPerson(String $person, String $table): void
    {
        $personName = explode(' ', $person);

        if(count($personName) === 1){
            $this->newPersonOnlyName($personName[0], $table);
        } else {
            if($table === 'actor') $this->newActor($personName);
            else $this->newDirector($personName);
        }
    }

    private function newActor(Array $actor): void
    {
        $insert = $this->connect->prepare('INSERT INTO actor(nom, cognom) VALUES (?,?)');
        $insert->execute([$actor[0], $actor[1]]);
    }

    private function newDirector(Array $director): void
    {
        $insert = $this->connect->prepare('INSERT INTO director(nom, cognom) VALUES (?,?)');
        $insert->execute([$director[0], $director[1]]);
    }
    
    private function newPersonOnlyName(String $name, String $table): void
    {
        if($table === 'actor') $this->newActorOnlyName($name);
        else $this->newDirectorOnlyName($name);
    }

    private function newActorOnlyName(String $name): void
    {
        $insert = $this->connect->prepare('INSERT INTO actor(nom) VALUES (?)');
        $insert->execute([$name]);
    }

    private function newDirectorOnlyName(String $name): void
    {
        $insert = $this->connect->prepare('INSERT INTO director(nom) VALUES (?)');
        $insert->execute([$name]);
    }

    private function insertPersonFilm(int $idPerson, int $idFilm, String $table): void
    {
        if($table === 'actor') $this->insertActorFilm($idPerson, $idFilm);
        else $this->insertDirectorFilm($idPerson, $idFilm);
    }

    private function insertActorFilm(int $idPerson, int $idFilm): void
    {
        $insert = $this->connect->prepare('INSERT INTO pelicula_actor(id_pelicula, id_actor) VALUES (?,?)');
        $insert->execute([$idFilm, $idPerson]);
    }

    private function insertDirectorFilm(int $idPerson, int $idFilm): void
    {
        $insert = $this->connect->prepare('INSERT INTO pelicula_director(id_pelicula, id_director) VALUES (?,?)');
        $insert->execute([$idFilm, $idPerson]);
    }
}
?>