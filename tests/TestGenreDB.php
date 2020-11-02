<?php
use PHPUnit\Framework\TestCase;
use MyApp\includes\database\GenreDB as GENRE;

final class TestGenreDB extends TestCase
{
    public function testSelectGenreIdExists(): void
    {
        $genreDB = new GENRE();
        $genre = 'Aventura';
        $result = json_decode($genreDB->getGenreID($genre), true);
        $result = $result[0]['id'];
        $this->assertNotEmpty($result);
    }

    public function testSelectGenreIdNoExists(): void
    {
        $genreDB = new GENRE();
        $genre = 'Patata';
        $result = json_decode($genreDB->getGenreID($genre), true);
        $result = $result[0]['id'];
        $this->assertEmpty($result);
    }
}

?>