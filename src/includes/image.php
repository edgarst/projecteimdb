<?php 
require("connection_db.php");
    class Image {

        // Image Comprovation
        function check_image($img){
            $img_folder = "../content/img/";
            $file = $img_folder . basename($img["caratula"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($file,PATHINFO_EXTENSION));
        
            // It's an image?
            if(isset($_POST["submit"])) {
                $check = getimagesize($img["caratula"]["tmp_name"]);
                if($check == false) {
                    $img_error = "El fitxer no és una imatge";
                    $uploadOk = 0;
                }
            }
        
            // It already exists?
            if (file_exists($file)) {
                $img_error = "El fitxer ja existeix.";
                $uploadOk = 0;
            }
        
            // Size limitation
            if ($img["caratula"]["size"] > 500000) {
                $img_error = "Ho sento el fitxer pesa massa";
                $uploadOk = 0;
            }
        
            // Ok? Then upload it
            if ($uploadOk == 0) {
                $img_error = "El fitxer no s'ha penjat. " . $img_error;
            } else {
                if (move_uploaded_file($img["caratula"]["tmp_name"], $file)) {
                    $img_error = "El fitxer ". basename( $img["caratula"]["name"]). " s'ha penjat correctament.";
                } else {
                    $img_error = "Hi ha hagut un error a l'hora de penjar el fitxer. Torna a provar en un altre moment.";
                }
            } 
            return $img_error;
        }
    }
?>