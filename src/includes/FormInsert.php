<?php namespace MyApp\includes;
use MyApp\includes\database\ConnectionDB as CONNECTION;
use MyApp\includes\database\FilmDB as FILMDB;
use MyApp\includes\Film as FILM;
use MyApp\includes\Image as IMAGE;

class FormInsert
{
    private $film;
    private $image;

    public function __construct()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $this->image = new IMAGE();
            $this->createFilm();
            $filmDB = new FILMDB($this->film);
            $filmDB->insertFilm();
        }

        // $img_error = $image->check_image($_FILES);
    }

    function createFilm(): void
    {
        $img = $this->image->getFileUrl();
        $this->film = new FILM($_POST['title'], $_POST['sinopsis'], $_POST['release'], 
            $_POST['rating'], $_POST['platform'], $img);
    }
}
?>