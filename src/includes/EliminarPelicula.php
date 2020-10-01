<<<<<<< HEAD
<?php 
=======
<?php namespace MyApp\includes;
>>>>>>> feature/Database_Test
class EliminarPelicula{
    private $connexio;

    public function __construct(){
        $this->connexio = BaseDades::connect();
    }

    function eliminar($titol){
        try {
            $stmt = $this->connexio->prepare("DELETE FROM pelicula WHERE titol LIKE :titol");
            $stmt->execute(array(':titol' => $titol));
            return "La película ".$titol." s'ha eliminat correctament";
        } catch (PDOException $ex) {
            return  $ex->getMessage();
        }
    }
}
?>