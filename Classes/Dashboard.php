<?php

class Dashboard
{
    public $connection;

    function __construct($connection)
    {
        $this->connection = $connection;
    }

    function featured($type)
    {
        $result = mysqli_query($this->connection,"SELECT 'Movie' AS type, id,title,release_year,thumbnail FROM movies WHERE feature LIKE '%$type%' UNION SELECT 'Webseries', id,title,release_year,thumbnail FROM webseries WHERE feature LIKE '%$type%' UNION SELECT 'Episode', id,title,release_year,thumbnail FROM webseries_seasons WHERE feature LIKE '%$type%'");
        return $result;
    }

    function featured_users($type)
    {
        $result = mysqli_query($this->connection,"SELECT 'Movie' AS type, id,title,release_year,thumbnail,part_1_id,part,language FROM movies WHERE feature LIKE '%$type%' UNION SELECT 'Webseries', id,title,release_year,thumbnail,part_1_id,season_number,language FROM webseries WHERE feature LIKE '%$type%' UNION SELECT 'Episode', id,title,release_year,thumbnail,season_number,episode_number,webseries_id FROM webseries_seasons WHERE feature LIKE '%$type%'");
        return $result;
    }

    function delete_from_feature($type,$id,$feature){
        if($type == 'Movie')
        {
            $table = 'movies';
        }else if($type == 'Webseries')
        {
            $table = 'webseries';
        }else if($type == 'Episode')
        {
            $table = 'webseries_seasons';
        }
        $result = mysqli_query($this->connection,"UPDATE $table SET feature = '$feature' WHERE id = '$id'");
        return $result;
    }
}