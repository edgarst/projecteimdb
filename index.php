<link rel="stylesheet" href="src/css/header.css">
<link rel="stylesheet" href="src/css/content.css">
<link rel="stylesheet" href="src/css/formMovie.css">


<?php 
    $version = 'v2.1.0';
    require 'vendor/autoload.php';
    require('src/includes/ConnectionDB.php');
    include('src/content/header.html');
    include('src/content/content.php');

    /*
    use MyApp\includes\FilmDB as film;
    $film = new film();

    $infoFilm = $film->searchFilm('Vengadores');
    $info = json_decode($infoFilm, true);
    echo $info[0]['titol'];

    $infoDirectors = $film->filmDirectors('Vengadores: Endgame');
    $info = json_decode($infoDirectors, true);
    foreach ($info as $row) {
        echo $row['nom'];
        echo $row['cognom'];
    }

    $infoActors = $film->filmActors('Vengadores');
    $info = json_decode($infoActors, true);
    foreach ($info as $row) {
        echo $row['nom'];
        echo $row['cognom'];
    }
    */
?>