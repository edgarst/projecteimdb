<?php namespace MyApp\includes;
use MyApp\includes\database\ConnectionDB as CONNECTION;

class EditMovie
{
    private $connexio;

    public function __construct()
    {
        $this->connexio = BaseDades::connect();
    }

    function edit($id, $titol)
    {
        try {
            $stmt = $this->connexio->prepare("UPDATE pelicula SET titol = :titol WHERE id LIKE :id");
            $stmt->execute(array(':titol' => $titol, ':id' => $id));
            return "El titol de la pelicula amb id: {$id} ara és: {$titol}";
        } catch (PDOException $ex) {
            return  $ex->getMessage();
        }
    }
}
?>