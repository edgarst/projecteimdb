<?php  namespace MyApp\includes;

use MyApp\includes\FilmDB as FilmDB;
use MyApp\includes\PlatformDB as PlatformDB;

class MostrarPelicula
{
    function showMovie(String $title): String
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

    function showMovieByGenre(String $genre): String
    {
        $film = new FilmDB();
        $movies = json_decode($film->getFilmsByGenre($genre), true);
        foreach ($movies as $movie) {
            $this->showMovie($movie['titol']);
        }
    }

    private function showMoviePersons(Array $moviePersons, String $key): void
    {
        echo "{$key}: ";
        for ($i=0; $i < count($moviePersons) ; $i++) { 
            echo "{$moviePersons[$i]['nom']} ";
            echo "{$moviePersons[$i]['cognom']}";
            if($i < count($moviePersons)-1) echo ', ';
        }
    }

    private function getFilmsArray(String $title): Array
    {
        $film = new FilmDB();
        $platform = new PlatformDB();
    
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

    private function Directors(String $film, String $title): String
    {
        return json_decode($film->filmDirectors($title), true);
    }

    private function Actors(String $film, String $title): String
    {
        return json_decode($film->filmActors($title), true);
    }
}