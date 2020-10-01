<?php namespace MyApp\includes;
use MyApp\includes\connectionDB as connection;

class Image 
{
    private $file;

    public function __construct(){
        $imgFolder = 'src/content/img/';
        $file = $imgFolder . basename($img['caratula']['name']);
    }

    function uploadImage($img)
    {
        $imageTrue = checkImage();
        if($imageTrue!==true){
            return $imageTrue;
        }

        if (move_uploaded_file($img['caratula']['tmp_name'], $file)) {
            $fileName = basename($img['caratula']['name']);
            return "El fitxer {$fileName} s'ha penjat correctament.";
        }

        return 'Hi ha hagut un error a l\'hora de penjar el fitxer. Torna a provar en un altre moment.';
    }
    
    // Image Comprovation
    private function checkImage()
    {
        // It's an image?
        if(isset($_POST['submit'])) {
            $check = getimagesize($img['caratula']['tmp_name']);
            if($check == false) {
                return 'El fitxer no és una imatge';
            }
        }

        // It already exists?
        if (file_exists($this->file)) {
            return 'El fitxer ja existeix.';
        }

        // Size limitation
        if ($img['caratula']['size'] > 500000) {
            return 'Ho sento el fitxer pesa massa';
        }

        return true;
    }
}
?>