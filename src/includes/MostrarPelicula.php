<?php 
class MostrarPelicula{
    private $nom;
    private $data;
    private $connexio;

    public function __construct(){
        $this->nom = "Vengadores";
        $this->data = 2012;
        $this->connexio = BaseDades::connect();
    }

    function mostrarDades($id){
        $pelicula = $this->getPelicula($id);

        foreach ($pelicula as $row) {
            $dades = [
                'id' => $row['id'],
                'titol' => $row['titol'],
                'sinopsis' => $row['sinopsis'],
                'data' => $row['publicacio'],
                'valoracio' => $row['valoracio'],
                'caratula' => $row['caratula'],
                'plataforma' => $row['plataforma']
            ];
        }
        

        return $dades;
        // return [
        //     'nom' => $this->nom,
        //     'data' => $this->data
        // ];
    }

    function getPelicula($id){
        try{
            $sql = $this->connexio->prepare("SELECT * FROM pelicula WHERE id = ".$id);
            $sql->execute(array());
            $result = $sql->fetchAll();

            return $result;
        }catch(PDOException $e){
            echo "ERROR: " . $e->getMessage();
        }
    }

    private function getPeliculaDB($id){
        $sql = $connect->prepare("SELECT * FROM pelicula WHERE id = ".$id);
        $sql->execute(array());
        $result = $sql->fetchAll();

        return $result;
    }
}

?>