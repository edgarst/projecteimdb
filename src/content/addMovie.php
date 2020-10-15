<?php 
    // Streaming platform query
    $platformDB = new PlatformDB();
    $plataforma = $platformDB->getPlatforms();

    // Check for errors
    $title_error = $sinopsis_error = $img_error = "";
    function empty_title($title){
        global $title_error;
        if (empty($title)) {
            $title_error = "Title is required";
            return true;
        }
        return false;
    }

    function empty_sinopsis($sinopsis){
        global $sinopsis_error;
        if (empty($sinopsis)) {
            $sinopsis_error = "Sinopsis is required";
            return true;
        }
        return false;
    }

    function empty_image($img){
        global $img_error;
        if (empty($img)) {
            $img_error = "Image is required";
            return true;
        }
        return false;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check Required files
        $title = $_POST["title"];
        $title_ok = !empty_title($title);
        
        $sinopsis = $_POST["sinopsis"];
        $sinopsis_ok = !empty_sinopsis($sinopsis);

        $img = $_POST["caratula"];
        $img_ok = !empty_image($img);

        if ($title_ok && $sinopsis_ok && $img_ok) {
            $image = new Image();
            $img_error = $image->check_image($_FILES);
        }
    }
?>


