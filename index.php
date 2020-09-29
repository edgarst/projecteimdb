<link rel="stylesheet" href="src/css/style.css">


<?php 
    $version = "v2.0.0";
<<<<<<< HEAD
    require_once("src/includes/ConnectionDB.php");
    include_once("src/includes/PlatformDB.php");

    include_once("src/content/header.html");
    include_once("src/content/content.php");
    include_once("src/content/addMovie.php");
=======
    require "vendor/autoload.php";
    require("src/includes/connectionDB.php");
    include("src/content/header.html");
    include("src/content/content.php");
>>>>>>> feature/Database_Test
?>