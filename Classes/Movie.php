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

    function get_all_movies_by_id($id)
    {
        $result = mysqli_query($this->connection,"SELECT * FROM movies WHERE id = '$id'");
        return $result;
    }

    function get_all_movies_with_query($part,$search,$language)
    {
        $db_query = "SELECT * FROM movies WHERE watchable = ('active' OR 'blocked')";
        if($part != 0)
        {
            $db_query .= "AND part = '$part'";
        }
        if($language != '0')
        {
            $db_query .= "AND language = '$language'";
        }
        if($search != '')
        {
            $db_query .= "AND title LIKE '$search%'";
        }
        $db_query .= " ORDER BY title";
        $result = mysqli_query($this->connection,$db_query);
        return $result;
    }
}
