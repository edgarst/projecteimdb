<?php namespace MyApp\includes;
use MyApp\includes\ConnectionDB as CONNECTION;
use PDO;

class DeleteMovie
{
    private $connexio;

    public function __construct()
    {
        $this->connexio = CONNECTION::connect();
    }

    function eliminar($titol)
    {
        try {
            $stmt = $this->connexio->prepare('DELETE FROM pelicula WHERE titol LIKE :titol');
            $stmt->execute(array(':titol' => $titol));
            return "La película {$titol} s'ha eliminat correctament";
        } catch (PDOException $ex) {
            return  $ex->getMessage();
        }
    }
}
?>