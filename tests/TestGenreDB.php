<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use MyApp\includes\database\GenreDB as GENRE;

class TestGenreDB extends TestCase
{
    function testSelectGenreIdExists(): void
    {
        $conn = Database::getConnection();
        $genreDB = new GENRE();
        $genre = 'Aventura';
        $result = json_decode($genreDB->getGenreID($genre), true);
        $result = $result[0]['id'];

        $this->assertNotEmpty($result);
    }

    function testSelectGenreIdNoExists(): void
    {
        $genreDB = new GENRE();
        $genre = 'Patata';
        $result = json_decode($genreDB->getGenreID($genre), true);
        $result = $result[0]['id'];

        $this->assertEmpty($result);
    }
}

?>