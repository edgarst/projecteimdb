<?php namespace MyApp\includes\database;
use MyApp\includes\database\connectionDB as CONNECTION;
use MyApp\includes\database\PlatformDB as PLATFORM;
use MyApp\includes\database\GenreDB as GENRE;
use MyApp\includes\Film as FILM;
use PDO;

class FilmDB
{
    private $connect;
    private $film;

    public function __construct(FILM $film = null)
    {
        $this->connect = CONNECTION::connect();
        $this->film = $film;
    }

    function searchFilm(String $title): String
    {
        $sql = $this->connect->prepare('SELECT * FROM pelicula WHERE titol LIKE ?');
        $sql->execute(["%{$title}%"]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($result);
    }

    function deleteFilm(): void
    {
        $idFilm = $this->getFilmID($this->film->getTitle());
        $stmt = $this->connexio->prepare('DELETE FROM pelicula WHERE id LIKE ?');
        $stmt->execute([$idFilm]);
    }

    function insertFilm(): String
    {
        $platformDB = new PLATFORM();
        $platform = $platformDB->getPlatformID($this->film->getPlatform());
        $release = date('Y', strtotime($this->film->getRelease()));

        $insert = $this->connect->prepare('INSERT INTO pelicula(titol, sinopsis, valoracio, publicacio, plataforma, caratula)
        VALUES (?,?,?,?,?,?)');
        
        try {
            $insert->execute([$this->film->getTitle(), $this->film->getSinopsis(), $this->film->getRating(), $release, $platform, $this->film->getImg()]);
        } catch (\Exception $e) {
            return 'Error inserting film to database. Check if the filename is too long, try again later or if the problem persist contact with an administrator.';
        }

        return '1'; // 1 = okey
    }

    function getFilms(): String
    {
        $sql = $this->connect->prepare('SELECT * FROM pelicula');
        $sql->execute([]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        
        return json_encode($result);
    }

    function filmDirectors(): String
    {
        $directors = json_decode($this->getPersonsID($this->film->getTitle(), 'director'), true);
        $directorsID = implode(',',$this->createArray($directors, 'director'));

        $sql = $this->connect->prepare("SELECT nom, cognom FROM director WHERE id IN ({$directorsID})");
        $sql->execute([]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($result);
    }

    function filmActors(): String
    {
        $actors = json_decode($this->getPersonsID($this->film->getTitle(), 'actor'), true);
        $actorsID = implode(',',$this->createArray($actors, 'actor'));
        
        $sql = $this->connect->prepare("SELECT nom, cognom FROM actor WHERE id IN ({$actorsID})");
        $sql->execute([]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($result);
    }
    
    private function getPersonsID(String $title, String $col): String
    {
        $id = json_decode($this->getFilmID($title), true);
        $id = $id[0]['id'];
        $sql = $this->connect->prepare("SELECT id_{$col} FROM pelicula_{$col} WHERE id_pelicula = :id");
        $sql->execute(['id' => $id]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        
        return json_encode($result);
    }

    private function createArray(Array $values, String $col): Array
    {
        $i=0; $info=[];
        foreach ($values as $item) {
            $key = ":id{$i}";
            $info[$key] = $item["id_{$col}"];
            $i++;
        }
        return $info;
    }

    function getFilmID(String $title): String
    {
        $sql = $this->connect->prepare('SELECT id FROM pelicula WHERE titol LIKE :title');
        $sql->execute(['title' => $title]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        
        return json_encode($result);
    }

    function getFilmByID(int $id): String
    {
        try{
            $sql = $this->connect->prepare('SELECT * FROM pelicula WHERE id = :id');
            $sql->execute(['id' => $id]);
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($result);
        }catch(PDOException $e){
            return "ERROR: {$e->getMessage()}";
        }
    }

    function getFilmsByGenre(Array $genre): String
    {
        $filmsID = $this->filmsIdByGenre($genre);

        try{
            $sql = $this->connect->prepare("SELECT * FROM pelicula WHERE id IN ({$filmsID})");
            $sql->execute([]);
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($result);
        }catch(PDOException $e){
            return "ERROR: {$e->getMessage()}";
        }
    }

    private function filmsIdByGenre(Array $genre): String
    {
        $genreDB = new GENRE();
        $genreID = $this->filterByGenre($genre);
        $films = json_decode($genreDB->getFilmID($genreID), true);
        $filmsID = implode(', ', $this->createArray($films, 'pelicula'));
        
        return $filmsID;
    }

    private function filterByGenre(Array $genres): String
    {
        $genreDB = new GENRE();
        $genresID='';
        for ($i=0; $i < count($genres); $i++) { 
            $id = json_decode($genreDB->getGenreID($genres[$i]), true);
            $genresID=$genresID.$id[0]['id'];
            if($i<count($genres)-1) $genresID.=', ';
        }

        return $genresID;
    }

    private function platformId(String $platform): int
    {
        $platformDB = new PLATFORM();

        return $platformDB->getPlatformId($platform);
    }

    function getFilmsByPlatform(String $platform): String
    {
        $platformId = $this->platformId($platform);
        
        $sql = $this->connect->prepare('SELECT * FROM pelicula WHERE plataforma = ?');
        $sql->execute([$platformId]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        
        return json_encode($result);
    }

    function getFilmsByPlatformAndGenre(String $platform, Array $genres): String
    {
        $filmsID = $this->filmsIdByGenre($genres);
        $platformId = $this->platformId($platform);
        
        $sql = $this->connect->prepare("SELECT * FROM pelicula WHERE plataforma = ? AND id IN ({$filmsID})");
        $sql->execute([$platformId]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        
        return json_encode($result);
    }

    function getFilmsByRelease(Array $releases): String
    {
        $release = $this->releaseString($releases);
        $sql = $this->connect->prepare("SELECT * FROM pelicula WHERE publicacio IN ({$release})");
        $sql->execute([]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($result);
    }

    function getFilmsByReleaseAndGenre(Array $releases, Array $genres): String
    {
        $filmsID = $this->filmsIdByGenre($genres);
        $release = $this->releaseString($releases);

        $sql = $this->connect->prepare("SELECT * FROM pelicula WHERE publicacio IN ({$release}) AND id IN ({$filmsID})");
        $sql->execute([]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($result);
    }

    function getFilmsByReleaseAndPlatform(Array $releases, String $platform): String
    {
        $release = $this->releaseString($releases);
        $platformId = $this->platformId($platform);
        
        $sql = $this->connect->prepare("SELECT * FROM pelicula WHERE publicacio IN ({$release}) AND plataforma = ?");
        $sql->execute([$platformId]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($result);
    }

    private function releaseString(Array $releases): String
    {
        $string = '';
        for ($i=0; $i < count($releases); $i++) { 
            $string=$string.$releases[$i];
            if($i<count($releases)-1) $string.=', ';
        }

        return $string;
    }

    function getAllReleases(): String
    {
        $sql = $this->connect->prepare('SELECT DISTINCT publicacio FROM pelicula ORDER BY publicacio ASC');
        $sql->execute([]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        
        return json_encode($result);
    }

    function getFilmsByAllFilter(String $platform, Array $genres, Array $releases): String
    {
        $release = $this->releaseString($releases);
        $platformId = $this->platformId($platform);
        $filmsID = $this->filmsIdByGenre($genres);
        
        $sql = $this->connect->prepare("SELECT * FROM pelicula WHERE publicacio IN ({$release}) AND id IN ({$filmsID}) AND plataforma = ?");
        $sql->execute([$platformId]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($result);
    }

    function getFilmsByFilter(Array $filter)
    {
        $option = $this->filtersSet($filter);
        if($option === 1) return $this->getFilmsByPlatform($filter['platform']);
        if($option === 2) return $this->getFilmsByGenre($filter['genres']);
        if($option === 3) return $this->getFilmsByRelease($filter['releases']);
        if($option === 4) return $this->getFilmsByPlatformAndGenre($filter['platform'], $filter['genres']);
        if($option === 5) return $this->getFilmsByReleaseAndGenre($filter['releases'], $filter['genres']);
        if($option === 6) return $this->getFilmsByReleaseAndPlatform($filter['releases'], $filter['platform']);
        return $this->getFilmsByAllFilter($filter['platform'], $filter['genres'], $filter['releases']);
    }
    /* 
        1 = Only platform
        2 = Only genre
        3 = Only release
        4 = Platform && genre
        5 = Genre && release
        6 = Platform && release
        7 = All set
    */

    private function filtersSet(Array $filter): int
    {
        $platform = $this->platformSet($filter);
        $genre = $this->genreSet($filter);
        $release = $this->releaseSet($filter);

        if($platform && $genre && $release) return 7;
        
        $filter = $this->twoFilter($platform, $genre, $release); // 0 = condition not here
        if($filter !== 0) return $filter;

        $filter = $this->oneFilter($platform, $genre, $release);
        if($filter !== 0) return $filter;
    }

    private function oneFilter(bool $platform, bool $genre, bool $release): int
    {
        if($release) return 3;
        if($genre) return 2;
        if($platform) return 1;

        return 0;
    }

    private function twoFilter(bool $platform, bool $genre, bool $release): int
    {
        if($platform && $release) return 6;
        if($genre && $release) return 5;
        if($platform && $genre) return 4;
        
        return 0;
    }

    private function platformSet(Array $filter): bool
    {
        if(isset($filter['platform'])) return true;
        return false;
    }

    private function genreSet(Array $filter): bool
    {
        if(!empty($filter['genres'])) return true;
        return false;
    }

    private function releaseSet(Array $filter): bool
    {
        if(!empty($filter['releases'])) return true;
        return false;
    }
}
?>