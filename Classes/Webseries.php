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

    function add_webseries_season($webseries_id,$episodes,$status){
        $episode_data = json_decode($episodes);
        foreach ($episode_data as $key => $value) {
        $description = mysqli_real_escape_string($this->connection,$value->description);
            $result = mysqli_query($this->connection,"INSERT INTO webseries_seasons (webseries_id,title,link,iframe,season_number,episode_number,thumbnail,description,release_year,duration,status) VALUES ('$webseries_id' , '$value->title' , '$value->link' , '$value->iframe' , '$value->season' , '$value->episode', '$value->thumbnail', '$description', '$value->year', '$value->duration' , '$status')");
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
