<?php namespace MyApp\content;
use MyApp\includes\ConnectionDB as CONNECTION;

class FormInsert
{
    public function __construct()
    {
        $image = new Image();
        $img_error = $image->check_image($_FILES);
    }
}
?>