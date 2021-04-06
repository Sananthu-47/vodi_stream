<?php

class Webseries
{
    public $connection;

    function __construct($connection)
    {
        $this->connection = $connection;
    }

    function add_webseries($title,$age,$thumbnail,$description,$status,$year,$language){
        $result = mysqli_query($this->connection,"INSERT INTO webseries (title,age,thumbnail,description,status,release_year,language) VALUES ('$title' , '$age' , '$thumbnail' , '$description' , '$status' ,'$year' , '$language')");
        if($result)
        {
            $last_id = mysqli_insert_id($this->connection);
            return $last_id;
        }
    }

    function add_webseries_season($webseries_id,$episodes,$status){
        $episode_data = json_decode($episodes);
        foreach ($episode_data as $key => $value) {
            $result = mysqli_query($this->connection,"INSERT INTO webseries_seasons (webseries_id,title,link,iframe,season_number,episode_number,thumbnail,description,release_year,duration,status) VALUES ('$webseries_id' , '$value->title' , '$value->link' , '$value->iframe' , '$value->season' , '$value->episode', '$value->thumbnail', '$value->description', '$value->year', '$value->duration' , '$status')");
            if(!$result)
        {
            return "error".mysqli_error($this->connection);
        }
        }
    }

    function get_all_webseries_seasons(){
        $result = mysqli_query($this->connection,"SELECT * FROM webseries_seasons WHERE watchable != 'deleted'");
        return $result;
    }

    function get_webseries_by_id($id){
        $result = mysqli_query($this->connection,"SELECT * FROM webseries WHERE id = '$id'");
        return $result;
    }
}
