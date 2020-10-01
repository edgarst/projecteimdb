<link rel="stylesheet" href="src/css/header.css">
<link rel="stylesheet" href="src/css/content.css">
<link rel="stylesheet" href="src/css/formMovie.css">


<?php 
    $version = 'v2.2.0';
    require 'vendor/autoload.php';
    require('src/includes/ConnectionDB.php');
    // include('src/content/header.html');
    // include('src/content/content.php');

    // include('src/includes/FilmDB.php');
    use MyApp\includes\FilmDB as film;
    $film = new film();
    // echo $film->filmDirectors('Vengadores: Endgame');
    $infoFilm = $film->searchFilm('Vengadores');
    echo $infoFilm;
?>