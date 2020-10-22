<?php namespace MyApp\includes;

class Image 
{
    private $file;

    public function __construct($imgName)
    {
        $imgFolder = 'src/content/img/';
        $this->file = $imgFolder . basename($imgName);
    }

    function getFileUrl(): String
    {
        return $this->file;
    }

    function uploadImage(): String
    {
        $imageTrue = $this->checkImage(); // true = (String) 1
        if($imageTrue!=='1'){
            return $imageTrue;
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $this->file)) {
            $fileName = basename($_FILES['file']['name']);
            return "The file {$fileName} has been uploaded.";
        }

        return 'There was an error uploading your file. Try again later.';
    }
    
    // Image Comprovation
    private function checkImage(): String
    {
        // It's an image?
        $check = getimagesize($_FILES['file']['tmp_name']);
        if($check == false) {
            return 'File is not an image.';
        }
        

        // It already exists?
        // if (file_exists($this->file)) {
        //     return 'File already exists.';
        // }

        // Size limitation
        if ($_FILES['file']['size'] > 500000) {
            return 'The file is too large.';
        }

        return true;
    }
}
?>