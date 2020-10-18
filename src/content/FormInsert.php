<?php namespace MyApp\content;
use MyApp\includes\database\ConnectionDB as CONNECTION;

class FormInsert
{
    public function __construct()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $this->insertForm();
        }

        $image = new Image();
        $img_error = $image->check_image($_FILES);
    }

    function insertForm()
    {

    }
}
?>