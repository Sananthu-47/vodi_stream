<?php

class Movie
{
    public $connection;

    function __construct($connection)
    {
        $this->connection = $connection;
    }

    function add_movie($title,$age,$thumbnail,$description,$status,$year,$part,$part_1,$movie_link,$movie_iframe,$duration,$language,$categories){
        $description = mysqli_real_escape_string($this->connection,$description);
        $category = '';
        foreach ($categories as $key => $value) {
            $category.=$value;
            if($key < count($categories) - 1)
            {
                $category.=',';
            }
        }
        $result = mysqli_query($this->connection,"INSERT INTO movies (title,age,thumbnail,description,status,release_year,part,part_1_id,link,iframe,duration,language,category) VALUES ('$title' , '$age' , '$thumbnail' , '$description' , '$status' ,'$year' , '$part' , '$part_1' ,'$movie_link' , '$movie_iframe' , '$duration' , '$language' , '$category')");
        if($result)
        {
            return true;
        }
    }

    function update_movie($id,$title,$age,$thumbnail,$description,$status,$year,$part,$part_1,$movie_link,$movie_iframe,$duration,$language,$categories){
        $description = mysqli_real_escape_string($this->connection,$description);
        $category = '';
        foreach ($categories as $key => $value) {
            $category.=$value;
            if($key < count($categories) - 1)
            {
                $category.=',';
            }
        }
        $result = mysqli_query($this->connection,"UPDATE movies SET title ='$title' , age ='$age' , thumbnail ='$thumbnail' , description ='$description' , status ='$status' , release_year ='$year' , part ='$part' , part_1_id ='$part_1' , link ='$movie_link' , iframe ='$movie_iframe' , duration ='$duration' , language ='$language' , category ='$category' WHERE id = '$id'");
        if($result)
        {
            return true;
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

    function get_movie_by_id_and_search($get_value,$id)
    {
        $result = mysqli_query($this->connection,"SELECT $get_value FROM movies WHERE id = '$id'");
        $row = mysqli_fetch_array($result);
        return $row[0];
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
            $db_query .= "AND title LIKE '%$search%'";
        }
        $db_query .= " ORDER BY title";
        $result = mysqli_query($this->connection,$db_query);
        return $result;
    }
}
