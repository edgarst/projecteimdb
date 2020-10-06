<?php 
require 'vendor/autoload.php';

use MyApp\includes\FilmDB as filmDB;
use MyApp\includes\PlatformDB as platformDB;
use MyApp\includes\MostrarPelicula as showFilm;

if ($_GET['name']) {
    $movie = new showFilm();
    $movie->showMovie($_GET['name']);
}

if ($_GET['platform']) {
    $movie = new showFilm();
    $movie->showMovie($_GET['platform']);
}

if ($_GET['genre']) {
    $movie = new showFilm();
    $movie->showMovie($_GET['genre']);
}

?>