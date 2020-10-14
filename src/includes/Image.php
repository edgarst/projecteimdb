<?php namespace MyApp\includes;

class Image 
{
    private $file;

    public function __construct()
    {
        $imgFolder = 'src/content/img/';
        $file = $imgFolder . basename($img['caratula']['name']);
    }

    function uploadImage(): String
    {
        $imageTrue = checkImage();
        if($imageTrue!==true){
            return $imageTrue;
        }

        if (move_uploaded_file($_FILES['caratula']['tmp_name'], $file)) {
            $fileName = basename($_FILES['caratula']['name']);
            return "The file {$fileName} has been uploaded.";
        }

        return 'There was an error uploading your file. Try again later.';
    }
    
    // Image Comprovation
    private function checkImage(): String
    {
        // It's an image?
        if(isset($_POST['submit'])) {
            $check = getimagesize($_FILES['caratula']['tmp_name']);
            if($check == false) {
                return 'File is not an image.';
            }
        }

        // It already exists?
        if (file_exists($this->file)) {
            return 'File already exists.';
        }

        // Size limitation
        if ($_FILES['caratula']['size'] > 500000) {
            return 'The file is too large.';
        }
    }
}
?>