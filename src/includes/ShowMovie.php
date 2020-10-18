<?php 
namespace MyApp\includes;
use MyApp\includes\database\FilmDB as FILMDB;
use MyApp\includes\database\PlatformDB as PLATFORMDB;

class ShowMovie
{
    function showMovie(String $title): String
    {
        $movies = $this->_getFilmsArray($title);
        return json_encode($movies);
    }

    function showMovieByGenre(String $genre): void
    {
        $film = new FILMDB();
        $movies = json_decode($film->getFilmsByGenre($genre), true);
        foreach ($movies as $movie) {
            $this->showMovie($movie['titol']);
        }
    }

    private function _getFilmsArray(String $title): Array
    {
        $film = new FILMDB();
        $platform = new PLATFORMDB();
    
        $filmInfo = $film->searchFilm($title);
        $filmInfo = json_decode($filmInfo, true);

        foreach ($filmInfo as $key => $value) {
            $movies[$value['id']] = $value;
            $movies[$value['id']]['directors'] = $this->_directors($film, $title);
            $movies[$value['id']]['actors'] = $this->_actors($film, $title);
            $movies[$value['id']]['plataforma'] = $platform->getPlatformName($movies[$value['id']]['plataforma']);
        }

        return $movies;
    }

    private function _directors(FILMDB $film, String $title): Array
    {
        return json_decode($film->filmDirectors($title), true);
    }

    private function _actors(FILMDB $film, String $title): Array
    {
        return json_decode($film->filmActors($title), true);
    }
}

?>