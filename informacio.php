<?php 
require 'vendor/autoload.php';

use MyApp\includes\FilmDB as FILMDB;
use MyApp\includes\PlatformDB as PLATFORMDB;
use MyApp\includes\MostrarPelicula as SHOWFILM;
use MyApp\includes\GenreDB as GENREDB;

if ($_GET['name']) {
    $movie = new SHOWFILM();
    $movie->showMovie($_GET['name']);
}

if ($_GET['platform']) {
    $movie = new showFilm();
    $movie->showMovie($_GET['platform']); // Not definitive (have to change)
}

if ($_GET['genre']) {
    $movie = new FILMDB();
    $movie->getFilmsByGenre($_GET['genre']);
}

?>