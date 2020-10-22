<?php 
require 'vendor/autoload.php';
header('Content-Type: application/json');

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

use MyApp\includes\database\FilmDB as FILMDB;
use MyApp\includes\database\PlatformDB as PLATFORM;
use MyApp\includes\database\GenreDB as GENREDB;
use MyApp\includes\ShowMovie as SHOWFILM;
use MyApp\includes\FormInsert as FORM;

// Show all films for HomePage
if(isset($_GET['home'])){
    $movies = new FILMDB();
    echo $movies->getFilms();
}

// Search Films by title
if (isset($_GET['search'])) {
    $movie = new FILMDB();
    echo $movie->searchFilm($_GET['search']);
}

// Get 1 film by title for MoviePage
if (isset($_GET['title'])) {
    $movie = new FILMDB();
    echo $movie->searchFilm($_GET['title']);
}

// Search Films by Platform
if (isset($_GET['platform'])) {
    $movie = new showFilm();
    $movie->showMovie($_GET['platform']); // Not definitive (have to change)
}

// Get all platforms
if(isset($_GET['platforms'])){
    $platforms = new PLATFORM();
    echo $platforms->getPlatforms();
}

// Get all genres
if(isset($_GET['genres'])){
    $genres = new GENREDB();
    echo $genres->getGenres();
}

// Search Films by Genre
if (isset($_GET['genre'])) {
    $movie = new FILMDB();
    $show = new SHOWFILM();
    $show->showMovieByGenre($_GET['genre']);
    // $movies = json_decode($movie->getFilmsByGenre($_GET['genre']), true);

}

if(isset($_GET['insertForm'])){
    $form = $_POST['insertFilm'];
    $form = json_decode($form, true);
    $formInsert = new FORM($form);
    $formInsert->insertForm();
}

?>