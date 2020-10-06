<?php 
namespace MyApp\includes;

class MostrarPelicula
{
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

    function showMovie($title)
    {
        $movies = $this->getFilmsArray($title);
        echo '<pre>';
        print_r($movies);
        echo '</pre>';

        foreach ($movies as $key => $col) {
            foreach ($col as $key => $values) {
                if(is_array($values)) $this->showMoviePersons($values, $key);
                else echo "{$key}: {$values}";
                echo "<br />";
            }
            echo "<br />";
        }
    }

    private function showMoviePersons($moviePersons, $key)
    {
        echo "{$key}: ";
        for ($i=0; $i < count($moviePersons) ; $i++) { 
            echo "{$moviePersons[$i]['nom']} ";
            echo "{$moviePersons[$i]['cognom']}";
            if($i < count($moviePersons)-1) echo ', ';
        }
    }

    private function getFilmsArray($title)
    {
        $film = new filmDB();
        $platform = new platformDB();
    
        $filmInfo = $film->searchFilm($title);
        $filmInfo = json_decode($filmInfo, true);

        foreach ($filmInfo as $key => $value) {
            $movies[$value['id']] = $value;
            $movies[$value['id']]['directors'] = $this->Directors($film, $title);
            $movies[$value['id']]['actors'] = $this->Actors($film, $title);
            $movies[$value['id']]['plataforma'] = $platform->getPlatformName($movies[$value['id']]['plataforma']);
        }

        return $movies;
    }

    private function Directors($film, $title)
    {
        return json_decode($film->filmDirectors($title), true);
    }

    private function Actors($film, $title)
    {
        return json_decode($film->filmActors($title), true);
    }
}

?>