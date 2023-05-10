<?php

namespace Src\Repository;

use Core\DBManager\DatabaseManager;

class MovieRepository
{

    public static function getAllMovies()
    {
        $dbm = DatabaseManager::getInstance();
        $movies = $dbm->connection->query("
            SELECT m.*, ma.movie_asset_url
            FROM movie m
            INNER JOIN movie_asset ma on ma.movie_id=m.movie_id 
            WHERE ma.movie_asset_type='poster'")->fetch_all();
        $movies = array_map(function ($movie) {
            $movie['id'] = $movie[0];
            $movie['name'] = $movie[1];
            $movie['price'] = $movie[2];
            $movie['description'] = $movie[3];
            $movie['producer'] = $movie[4];
            $movie['date'] = $movie[5];
            $movie['duration'] = $movie[6];
            $movie['asset_url'] = $movie[7];
            return $movie;
        }, $movies);
        return $movies;
    }

    public static function getAllAvailableMovies()
    {
        $dbm = DatabaseManager::getInstance();
        $movies = $dbm->connection->query("
            SELECT DISTINCT m.*, ma.movie_asset_url FROM movie m
            INNER JOIN movie_asset ma ON ma.movie_id=m.movie_id
            INNER JOIN session s ON m.movie_id=s.movie_id
            WHERE ma.movie_asset_type = 'poster' AND s.session_time>'" . date('Y-m-d H:i:s') . "}'")->fetch_all();
        $movies = array_map(function ($movie) {
            $movie['id'] = $movie[0];
            $movie['name'] = $movie[1];
            $movie['price'] = $movie[2];
            $movie['description'] = $movie[3];
            $movie['producer'] = $movie[4];
            $movie['date'] = $movie[5];
            $movie['duration'] = $movie[6];
            $movie['asset_url'] = $movie[7];
            return $movie;
        }, $movies);
        return $movies;
    }

    public static function getMovieById(int $id)
    {
        $dbm = DatabaseManager::getInstance();
        $cinema = $dbm->connection->query("
            SELECT m.*, group_concat(g.genre_name) as genres
            FROM movie m INNER JOIN movie_genre mg ON mg.movie_id=m.movie_id
            INNER JOIN genre g ON g.genre_id=mg.genre_id
            WHERE m.movie_id='{$id}'
            GROUP BY m.movie_id")
        ->fetch_assoc();

        $cinema['genres'] = explode(',', $cinema['genres']);
        $cinema['assets'] = $dbm->connection->query("
            SELECT movie_asset_url, movie_asset_type
            FROM movie_asset
            WHERE movie_id='{$id}'")->fetch_all();


        return $cinema;
    }

    public static function getAllGenres() {
        $dbm = DatabaseManager::getInstance();
        return $dbm->connection->query("SELECT * from genre")->fetch_all();
    }

//    public static function updateMovie()
    public static function getSimilarByName(string $name)
    {
        $dbm = DatabaseManager::getInstance();
        $movies = $dbm->connection->query("
            SELECT DISTINCT m.*, ma.movie_asset_url FROM movie m
            INNER JOIN movie_asset ma ON ma.movie_id=m.movie_id
            INNER JOIN session s ON m.movie_id=s.movie_id
            WHERE m.movie_name like '%{$name}%' AND ma.movie_asset_type = 'poster' AND s.session_time>'" . date('Y-m-d H:i:s') . "}'")->fetch_all();
        $movies = array_map(function ($movie) {
            $movie['id'] = $movie[0];
            $movie['name'] = $movie[1];
            $movie['price'] = $movie[2];
            $movie['description'] = $movie[3];
            $movie['producer'] = $movie[4];
            $movie['date'] = $movie[5];
            $movie['duration'] = $movie[6];
            $movie['asset_url'] = $movie[7];
            return $movie;
        }, $movies);
        return $movies;
    }
}