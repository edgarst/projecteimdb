<?php
    try{
        $connect = new PDO('mysql:host=localhost;dbname=imdb', 'root', '');
        $connect ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo "ERROR: " . $e->getMessage();
    }
?>