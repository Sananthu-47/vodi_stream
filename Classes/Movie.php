<?php

class Movie
{
    public $connection;
    public $no_of_records_per_page = 20;

    function __construct($connection)
    {
        $this->connection = $connection;
    }

    function add_movie($title,$age,$thumbnail,$description,$status,$year,$part,$part_1,$movie_link,$movie_iframe,$duration,$language,$categories,$director,$producer){
        $description = mysqli_real_escape_string($this->connection,$description);
        $category = '';
        foreach ($categories as $key => $value) {
            $category.=$value;
            if($key < count($categories) - 1)
            {
                $category.=',';
            }
        }
        $result = mysqli_query($this->connection,"INSERT INTO movies (title,age,thumbnail,description,status,release_year,part,part_1_id,link,iframe,duration,language,category,director,producer) VALUES ('$title' , '$age' , '$thumbnail' , '$description' , '$status' ,'$year' , '$part' , '$part_1' ,'$movie_link' , '$movie_iframe' , '$duration' , '$language' , '$category' , '$director' , '$producer')");
        if($result)
        {
            return true;
        }
    }

    function update_movie($id,$title,$age,$thumbnail,$description,$status,$year,$part,$part_1,$movie_link,$movie_iframe,$duration,$language,$categories,$director,$producer){
        $description = mysqli_real_escape_string($this->connection,$description);
        $category = '';
        foreach ($categories as $key => $value) {
            $category.=$value;
            if($key < count($categories) - 1)
            {
                $category.=',';
            }
        }
        $result = mysqli_query($this->connection,"UPDATE movies SET title ='$title' , age ='$age' , thumbnail ='$thumbnail' , description ='$description' , status ='$status' , release_year ='$year' , part ='$part' , part_1_id ='$part_1' , link ='$movie_link' , iframe ='$movie_iframe' , duration ='$duration' , language ='$language' , category ='$category' , director = '$director' , producer = '$producer' WHERE id = '$id'");
        if($result)
        {
            return true;
        }
    }

    function get_all_movies(){
        $result = mysqli_query($this->connection,"SELECT * FROM movies WHERE watchable != 'deleted'");
        return $result;
    }

    function get_all_movies_users(){
        $result = mysqli_query($this->connection,"SELECT * FROM movies WHERE watchable = 'active' ORDER BY title");
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

    function get_all_movies_with_query_to_admin($part,$search,$language)
    {
        $db_query = "SELECT * FROM movies WHERE watchable != 'deleted'";
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

    function get_all_movies_with_non_feature($part,$search,$language,$feature)
    {
        $db_query = "SELECT * FROM movies WHERE watchable = 'active'";
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
        if($feature != '')
        {
            $db_query .= "AND feature NOT LIKE '%$feature%'";
        }
        $db_query .= " ORDER BY title";
        $result = mysqli_query($this->connection,$db_query);
        return $result;
    }

    function get_movie_letter(){
        $result = mysqli_query($this->connection,"SELECT title FROM movies WHERE watchable = 'active' ORDER BY title");
        $letter_array = [];
        while($row = mysqli_fetch_assoc($result))
        {
            if(!array_search($row['title'][0],$letter_array))
            {
                array_push($letter_array,$row['title'][0]);
            }
        }
        return $letter_array;
    }

    function get_all_years(){
        $result = mysqli_query($this->connection,"SELECT release_year FROM movies WHERE watchable = 'active' ORDER BY release_year");
        $year_array = [];
        while($row = mysqli_fetch_assoc($result))
        {
            if(!array_search($row['release_year'],$year_array))
            {
                array_push($year_array,$row['release_year']);
            }
        }
        return $year_array;
    }

    function get_all_movies_by_query($search,$letters,$years,$order,$categorys,$page_number){
        $query = '';
        $query.="SELECT * FROM movies WHERE watchable = 'active'";
        if($search != '')
        {
            $query.=" AND title LIKE '$search%'";
        }
        if(strlen($letters)>2)
        {
            $letters = json_decode($letters);
            $query.=" AND (";
            foreach ($letters as $key => $value) {
                $query.="title LIKE '$value%'";
                if($key<count($letters)-1)
                {
                    $query.=" OR ";
                }
            }
            $query.=")";
        }
        if(strlen($categorys)>2)
        {
            $categorys = json_decode($categorys);
            $query.=" AND (";
            foreach ($categorys as $key => $value) {
                $query.="category LIKE '%$value%'";
                if($key<count($categorys)-1)
                {
                    $query.=" OR ";
                }
            }
            $query.=")";
        }
        if(strlen($years)>2)
        {
            $years = json_decode($years);
            $query.=" AND (";
            foreach ($years as $key => $value) {
                $query.="release_year = '$value'";
                if($key<count($years)-1)
                {
                    $query.=" OR ";
                }
            }
            $query.=")";
        }
        switch($order)
        {
            case '1':
                $query.=" ORDER BY title";
            break;
            case '2':
                $query.=" ORDER BY title DESC";
            break;
            case '3':
                $query.=" ORDER BY release_year";
            break;
            case '4':
                $query.=" ORDER BY id";
            break;
            default:
                $query.=" ORDER BY title";
            break;
        }
        if($page_number != '')
        {
            $offset = ($page_number-1) * $this->no_of_records_per_page;
            $query.=" LIMIT $offset, $this->no_of_records_per_page";
        }
        $result = mysqli_query($this->connection,$query);
        return $result;
    }

    function pagination(){
        $total_rows = $this->get_all_movies_users();
        $total_rows = mysqli_num_rows($total_rows);
        $total_pages = ceil($total_rows / $this->no_of_records_per_page);
        return $total_pages;
    }

}
