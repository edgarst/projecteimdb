<?php 
require 'vendor/autoload.php';
header('Content-Type: application/json');

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

use MyApp\includes\FilmDB as FILMDB;
use MyApp\includes\PlatformDB as PLATFORMDB;
use MyApp\includes\MostrarPelicula as SHOWFILM;
use MyApp\includes\GenreDB as GENREDB;

if ($_GET['title']) {
    $movie = new FILMDB();
    // $movie->showMovie($_GET['title']);
    echo $movie->searchFilm($_GET['title']);
}

if ($_GET['platform']) {
    $movie = new showFilm();
    $movie->showMovie($_GET['platform']); // Not definitive (have to change)
}

if ($_GET['genre']) {
    $movie = new FILMDB();
    $show = new SHOWFILM();
    $show->showMovieByGenre($_GET['genre']);
    // $movies = json_decode($movie->getFilmsByGenre($_GET['genre']), true);

}

?>