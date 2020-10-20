<?php namespace MyApp\includes;
use MyApp\includes\database\ConnectionDB as CONNECTION;
use MyApp\includes\database\FilmDB as FILMDB;
use MyApp\includes\Film as FILM;
use MyApp\includes\Image as IMAGE;

class FormInsert
{
    private $form;
    private $film;
    private $image;

    public function __construct($form)
    {
        $this->form = $form;
        // $img_error = $image->check_image($_FILES);
    }

    function insertForm(): void
    {
        $this->image = new IMAGE();
        $this->createFilm();
        $filmDB = new FILMDB($this->film);
        $filmDB->insertFilm();
    }

    function createFilm(): void
    {
        $img = $this->image->getFileUrl();
        $this->film = new FILM($this->form['title'], $this->form['sinopsis'], $this->form['release'], 
            $this->form['rating'], $this->form['platform'], $img);
    }
}
?>