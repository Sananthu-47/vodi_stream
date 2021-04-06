<?php

class Movie
{
    public $connection;

    function __construct($connection)
    {
        $this->connection = $connection;
    }

    function add_movie($title,$age,$thumbnail,$description,$status,$year,$part,$part_1,$movie_link,$movie_iframe,$duration,$language){
        $result = mysqli_query($this->connection,"INSERT INTO movies (title,age,thumbnail,description,status,release_year,part,part_1_id,link,iframe,duration,language) VALUES ('$title' , '$age' , '$thumbnail' , '$description' , '$status' ,'$year' , '$part' , '$part_1' ,'$movie_link' , '$movie_iframe' , '$duration' , '$language')");
        if($result)
        {
            $last_id = mysqli_insert_id($this->connection);
            return $last_id;
        }
    }

    function get_all_movies(){
        $result = mysqli_query($this->connection,"SELECT * FROM movies WHERE watchable != 'deleted'");
        return $result;
    }
}
