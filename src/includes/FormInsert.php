<?php namespace MyApp\includes;
use MyApp\includes\database\ConnectionDB as CONNECTION;
use MyApp\includes\database\FilmDB as FILMDB;
use MyApp\includes\database\GenreDB as GENREDB;
use MyApp\includes\database\PersonDB as PERSONDB;
use MyApp\includes\Film as FILM;
use MyApp\includes\Image as IMAGE;

class FormInsert
{
    private $form, $film, $image, $filmDB, $idFilm;

    public function __construct($form)
    {
        $this->form = $form;
    }

    function insertForm(): Array
    {
        $check = $this->checkFormFields(); // Check error when upload images or if film already exists
        if($this->checkError($check)) return $this->error($check);

        $this->createFilm();

        $check = $this->insertMovie(); // Check errors when inserting movie
        if($this->checkError($check)) return $this->error($check);

        $this->insertGenres($this->form['genres']); // Not validated because it's checkbox and values are added by programmer
        
        if(isset($this->form['directors'])) $this->insertPersons($this->form['directors'], 'director');
        
        if(isset($this->form['actors'])) $this->insertPersons($this->form['actors'], 'actor');

        return $true = [
            'info' => 'Film inserted successful',
        ];
    }

    private function createFilm(): void
    {
        $img = $this->image->getFileUrl();
        $this->film = new FILM($this->form['title'], $this->form['sinopsis'], $this->form['release'], 
            $this->form['rating'], $this->form['platform'], $img);
        
        $this->filmDB = new FILMDB($this->film);
    }

    private function checkFormFields(): String
    {
        $check = $this->insertImage(); // Check errors when insert image
        if($this->checkError($check)) return $this->error($check);
        
        if($this->filmExists()) return 'This film is already in database';

        return true;
    }

    private function filmExists(): bool
    {
        $checkFilm = new FILMDB();
        $result = $checkFilm->getFilmID($this->form['title']);
        $result = json_decode($result);
        if(!empty($result)) return true;

        return false;
    }

    private function checkError(String $check): bool
    {
        // true = (String) '1'
        if($check!=='1') return true;
        
        return false;
    }

    private function error(String $check): Array
    {
        return $false = [
            'error' => $check,
        ];
    }

    private function setFilmID(String $idFilm): void
    {
        $id = json_decode($idFilm, true);
        $this->idFilm = $id[0]['id'];
    }

    private function insertImage(): String
    {
        $imgName = $_FILES['file']['name'];
        $this->image = new IMAGE($imgName);
        return $this->image->uploadImage();
    }

    private function insertMovie(): String
    {
        $check = $this->filmDB->insertFilm();
        if($this->checkError($check)) return $check; // if there is an error
        
        $this->setFilmID($this->filmDB->getFilmID($this->form['title']));
        return $check;
    }

    private function insertGenres(String $genres): void
    {
        $genreDB = new GENREDB();
        $filmGenres = explode(',', $genres);

        for ($i=0; $i < count($filmGenres); $i++) { 
            $genre = $filmGenres[$i];
            $genreDB->insertGenreMovie($genre, $this->idFilm);
        }
    }

    private function insertPersons(String $persons, String $table): void
    {
        $personsDB = new PERSONDB();
        $arr_persons = explode(',', $persons);
        $personsDB->insertPersons($arr_persons, $this->idFilm, $table);
    }
}
?>