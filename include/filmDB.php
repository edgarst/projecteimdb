<?php
    require("connection_db.php");
    // require("film.php");
    class FilmDB{
        public static function searchFilm($title){
            $sql = $connect->prepare('SELECT * FROM pelicula WHERE titol LIKE $title');
            $sql->execute(array());
            $result = $sql->fetchAll();
        }

        public static function insertFilm($film){
            $title = $film->getTitle();
            $sinopsis = $film->getSinopsis();
            $rating = $film->getRating();
            $release = $film->getRelease();
            $release = date('Y', strtotime($release));
            $img = $film->getImg();
            $platform = $film->getPlatform();
            $platform = PlatformDB::getPlatformID($platform);

            $sql = "INSERT INTO pelicula(titol, sinopsis, valoracio, publicacio, plataforma, caratula)
            VALUES ($title, $sinopsis, $rating, $release, $platform, $img)";

            var_dump($sql);

            mysqli_query($connect, $sql);
        }
    }
?>