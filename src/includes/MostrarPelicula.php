<?php namespace MyApp\includes;
use MyApp\includes\connectionDB as connection;
class MostrarPelicula
{
    private $nom;
    private $data;
    private $connexio;

    public function __construct()
    {
        $this -> nom = 'Vengadores';
        $this -> data = 2012;
        $this -> connexio = connection::connect();
    }

    function mostrarDades($id)
    {
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
    }

    function getPelicula($id)
    {
        try{
            $sql = $this->connexio->prepare('SELECT * FROM pelicula WHERE id = :id');
            $sql->execute(['id' => $id]);
            $result = $sql->fetchAll();

            return $result;
        }catch(PDOException $e){
            return "ERROR: {$e->getMessage()}";
        }
    }

}

?>