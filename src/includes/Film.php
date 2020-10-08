<?php namespace MyApp\includes;
class Film
{
    private $title;
    private $sinopsis;
    private $release_date;
    private $rating;
    private $platform;
    private $img;

    public function __construct(String $title, String $sinopsis, String $release_date, int $rating, String $platform, String $img)
    {
        $this -> title = $title;
        $this -> sinopsis = $sinopsis;
        $this -> release_date = $release_date;
        $this -> rating = $rating;
        $this -> platform = $platform;
        $this -> img = $img;
    }

    function getTitle(): String
    {
        return $this->title;
    }

    function getSinopsis(): String
    {
        return $this->sinopsis;
    }

    function getRelease(): String
    {
        return $this->release_date;
    }

    function getRating(): int
    {
        return $this->rating;
    }

    function getPlatform(): String
    {
        return $this->platform;
    }

    function getImg(): String
    {
        return $this->img;
    }
}
?>