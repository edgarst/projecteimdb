<?php namespace MyApp\includes;
use MyApp\includes\database\ConnectionDB as CONNECTION;
use MyApp\includes\database\FilmDB as FILMDB;
use MyApp\includes\database\GenreDB as GENREDB;
use MyApp\includes\database\PersonDB as PERSONDB;
use MyApp\includes\Film as FILM;
use MyApp\includes\Image as IMAGE;

class FormInsert
{
    private $form;
    private $film;
    private $image;
    private $filmDB;

    public function __construct($form)
    {
        $this->form = $form;
        // $img_error = $image->check_image($_FILES);
    }

    function insertForm(): void
    {
        $imgName = $_FILES['file']['name'];
        $this->image = new IMAGE($imgName);
        // $this->image->uploadImage();
        $idMovie = $this->insertMovie();
        $genres = $this->insertGenres($this->form['genres']);
    }

    function insertMovie(): int
    {
        $img = $this->image->getFileUrl();
        $this->film = new FILM($this->form['title'], $this->form['sinopsis'], $this->form['release'], 
            $this->form['rating'], $this->form['platform'], $img);
        
        $this->filmDB = new FILMDB($this->film);
        $filmDB->insertFilm();
    }

    function insertGenres(String $genres): void
    {
        $genreDB = new GENREDB();
        $filmGenres = explode(',', $genres);
        $idFilm = $this->filmDB->getFilmID($this->form['title']);

        for ($i=0; $i < count($filmGenres); $i++) { 
            $genre = $filmGenres[$i];
            $genreDB->insertGenreMovie($genre, $idFilm);
        }
    }

    function insertDirectors(String $directors): void
    {
        $directorsDB = new PERSONDB();
        $arr_directors = explode(',', $directors);
        $directorsDB->insertDirectors($arr_directors);
    }
}
?>