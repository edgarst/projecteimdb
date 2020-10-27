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
        $check = $this->insertImage();
        if($this->checkError($check)) return $this->error($check);
        
        $check = $this->insertMovie(); // Check errors when insert movie
        if($this->checkError($check)) return $this->error($check);

        $this->insertGenres($this->form['genres']); // Not validated because it's checkbox and values are added by programmer

        $check = $this->insertPersons($this->form['directors'], 'director');
        if($this->checkError($check)){
            $this->filmDB->deleteFilm();
            return $this->error($check);
        }

        $check = $this->insertPersons($this->form['actors'], 'actor');
        if($this->checkError($check)){
            $this->filmDB->deleteFilm();
            return $this->error($check);
        }

        $check = 'Film inserted successful';

        return $true = [
            'info' => $check,
        ];
    }

    private function checkFormFields(): String
    {
        $check = $this->insertImage(); // Check errors when insert image
        if($this->checkError($check)) return $this->error($check);
        
        $check = $this->insertPersons($this->form['directors'], 'director');
        if($this->checkError($check)){
            $this->filmDB->deleteFilm();
            return $this->error($check);
        }

        $check = $this->insertPersons($this->form['actors'], 'actor');
        if($this->checkError($check)){
            $this->filmDB->deleteFilm();
            return $this->error($check);
        }
        
        return true;
    }

    private function checkError(String $check): bool
    {
        if($check!=='1') return true;
        
        // true = (String) 1
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
        $img = $this->image->getFileUrl();
        $this->film = new FILM($this->form['title'], $this->form['sinopsis'], $this->form['release'], 
            $this->form['rating'], $this->form['platform'], $img);
        
        $this->filmDB = new FILMDB($this->film);
        $check = $this->filmDB->insertFilm();

        if($check !== undefined) return $check;

        $this->setFilmID($this->filmDB->getFilmID($this->form['title']));
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

    private function insertPersons(String $persons, String $table): String
    {
        $personsDB = new PERSONDB();
        $arr_persons = explode(',', $persons);
        return $personsDB->insertPersons($arr_persons, $this->idFilm, $table);
    }
}
?>