<?php 
namespace MyApp\includes;
use MyApp\includes\database\FilmDB as FILMDB;
use MyApp\includes\database\PlatformDB as PLATFORMDB;

class ShowMovie
{
    function showMovie(String $title): void
    {
        $movies = $this->getFilmsArray($title);
        echo '<pre>';
        print_r($movies);
        echo '</pre>';
    }

    function showMovieByGenre(String $genre): void
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

    private function Directors(FILMDB $film, String $title): Array
    {
        return json_decode($film->filmDirectors($title), true);
    }

    private function Actors(FILMDB $film, String $title): Array
    {
        return json_decode($film->filmActors($title), true);
    }
}