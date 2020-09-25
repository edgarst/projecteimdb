<?php 
class Film {
    private $title;
    private $sinopsis;
    private $release_date;
    private $rating;
    private $platform;
    private $img;

    public function __construct($title, $sinopsis, $release_date, $rating, $platform, $img){
        $this -> $title = $title;
        $this -> $sinopsis = $sinopsis;
        $this -> $release_date = $release_date;
        $this -> $rating = $rating;
        $this -> $platform = $platform;
        $this -> $img = $img;
    }

    // Getters
    function getTitle(){
        return $this->title;
    }

    function getSinopsis(){
        return $this->sinopsis;
    }

    function getRelease(){
        return $this->release_date;
    }

    function getRating(){
        return $this->rating;
    }

    function getPlatform(){
        return $this->platform;
    }

    function getImg(){
        return $this->img;
    }
}
?>