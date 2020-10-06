<?php 
namespace MyApp\includes;
use MyApp\includes\connectionDB as connection;
use PDO;
class MostrarPelicula
{
    private $connexio;

    public function __construct()
    {
        $this -> connexio = connection::connect();
    }

    function mostrarDades($id)
    {
        $pelicula = $this->getPelicula($id);

        foreach ($pelicula as $row) {
            $dades = [
                'id' => $row['id'],
                'titol' => $row['titol'],
                'sinopsis' => $row['sinopsis'],
                'data' => $row['publicacio'],
                'valoracio' => $row['valoracio'],
                'caratula' => $row['caratula'],
                'plataforma' => $row['plataforma']
            ];
        }

        return $dades;
    }

    function getPelicula($id)
    {
        try{
            $sql = $this->connexio->prepare('SELECT * FROM pelicula WHERE id = :id');
            $sql->execute(['id' => $id]);
            $result = $sql->fetchAll();

            return $result;
        }catch(PDOException $e){
            return "ERROR: {$e->getMessage()}";
        }
    }

    function showMovie($title){
        $film = new filmDB();
        $platform = new platformDB();
    
        $filmInfo = $film->searchFilm($title);
        $filmInfo = json_decode($filmInfo, true)[0];
        
        echo '<pre>';
        print_r($filmInfo);
        echo '</pre>';

        $platformName = $platform->getPlatformName($filmInfo['plataforma']);
        
        foreach ($filmInfo as $key => $value) {
            echo "{$key}: {$value} <br />";
        }
        $this->showPeople($film, $filmInfo['titol'], 'directors');
        $this->showPeople($film, $filmInfo['titol'], 'actors');
    }

    private function showPeople($filmDB, $title, $person){
        $people = $this->checkPerson($filmDB, $title, $person);
        echo "{$person}: ";
        for ($i=0; $i < count($people); $i++) { 
            echo "{$people[$i]['nom']} ";
            echo $people[$i]['cognom'];
            if($i != count($people)-1) echo ", ";
        }
    }

    private function checkPerson($filmDB, $title, $person){
        if($person =='directors') return $this->Directors($filmDB, $title);
        return $this->Actors($filmDB, $title);
    }

    private function Directors($film, $title){
        return json_decode($film->filmDirectors($title), true);
    }

    private function Actors($film, $title){
        return json_decode($film->filmActors($title), true);
    }
}

?>