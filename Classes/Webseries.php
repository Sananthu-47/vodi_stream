<?php

class Webseries
{
    public $connection;

    function __construct($connection)
    {
        $this->connection = $connection;
    }

    function add_webseries($title,$season_number,$part_1,$age,$thumbnail,$description,$status,$year,$language,$categories){
        $description = mysqli_real_escape_string($this->connection,$description);
        $category = '';
        foreach ($categories as $key => $value) {
            $category.=$value;
            if($key < count($categories) - 1)
            {
                $category.=',';
            }
        }
        $result = mysqli_query($this->connection,"INSERT INTO webseries (title,season_number,part_1_id,age,thumbnail,description,status,release_year,language,category) VALUES ('$title' , '$season_number' , '$part_1' , '$age' , '$thumbnail' , '$description' , '$status' ,'$year' , '$language' , '$category')");
        if($result)
        {
            $last_id = mysqli_insert_id($this->connection);
            return $last_id;
        }else{
            return 0;
        }
    }

    function update_webseries($id,$title,$season,$part_1,$age,$thumbnail,$description,$status,$year,$language,$categories,$end_year){
        $description = mysqli_real_escape_string($this->connection,$description);
        $category = '';
        foreach ($categories as $key => $value) {
            $category.=$value;
            if($key < count($categories) - 1)
            {
                $category.=',';
            }
        }
        $result = mysqli_query($this->connection,"UPDATE webseries SET title ='$title' , age ='$age' , thumbnail ='$thumbnail' , description ='$description' , status ='$status' , release_year ='$year' , season_number ='$season' , part_1_id ='$part_1' , language ='$language' , category ='$category' , end_year ='$end_year' WHERE id = '$id'");
        if($result)
        {
            return true;
        }
    }

    function add_webseries_season($webseries_id,$episodes,$status){
        $episode_data = json_decode($episodes);
        foreach ($episode_data as $key => $value) {
        $description = mysqli_real_escape_string($this->connection,$value->description);
            $result = mysqli_query($this->connection,"INSERT INTO webseries_seasons (webseries_id,title,link,iframe,season_number,episode_number,thumbnail,description,release_year,duration,status) VALUES ('$webseries_id' , '$value->title' , '$value->link' , '$value->iframe' , '$value->season' , '$value->episode', '$value->thumbnail', '$description', '$value->year', '$value->duration' , '$status')");
            if($result)
            {
                return true;
            }
        }
    }

    function get_all_webseries_seasons(){
        $result = mysqli_query($this->connection,"SELECT * FROM webseries_seasons WHERE watchable != 'deleted'");
        return $result;
    }

    function get_all_webseries_seasons_by_seriesid($id){
        $result = mysqli_query($this->connection,"SELECT * FROM webseries_seasons WHERE watchable != 'deleted' AND webseries_id = '$id'");
        return $result;
    }

    function get_all_webseries(){
        $result = mysqli_query($this->connection,"SELECT * FROM webseries WHERE watchable != 'deleted'");
        return $result;
    }

    function get_all_webseries_users(){
        $result = mysqli_query($this->connection,"SELECT * FROM webseries WHERE watchable = 'active'");
        return $result;
    }

    function get_webseries_by_id($id){
        $result = mysqli_query($this->connection,"SELECT * FROM webseries WHERE id = '$id'");
        return $result;
    }

    function get_all_webseries_with_query($part,$search,$language)
    {
        $db_query = "SELECT * FROM webseries WHERE watchable = ('active' OR 'blocked')";
        if($part != 0)
        {
            $db_query .= "AND season_number = '$part'";
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
