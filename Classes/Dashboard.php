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
        $result = mysqli_query($this->connection,"SELECT 'Movie' AS type, id,title,release_year,thumbnail FROM movies WHERE watchable = 'active' AND feature LIKE '%$type%' UNION SELECT 'Webseries', id,title,release_year,thumbnail FROM webseries WHERE watchable = 'active' AND feature LIKE '%$type%' UNION SELECT 'Episode', id,title,release_year,thumbnail FROM webseries_seasons WHERE watchable = 'active' AND feature LIKE '%$type%'");
        return $result;
    }
    
    function addTo($type,$id,$feature)
    {
        if($type == 'movie')
        {
            $table = 'movies';
        }else if($type == 'webseries')
        {
            $table = 'webseries';
        }else if($type == 'episode')
        {
            $table = 'webseries_seasons';
        }
        $feature_updated = '';
        $feature_db = $this->getFeature($table,$id);
        if($feature_db == '')
        {
            $feature_updated = $feature;
        }else{
            $feature_updated = $feature_db.','.$feature;
        }
        $result = mysqli_query($this->connection,"UPDATE $table SET feature = '$feature_updated' WHERE id = '$id'");
    }

    function getFeature($table,$id){
        $result = mysqli_query($this->connection,"SELECT feature FROM $table WHERE id = '$id'");
        $result = mysqli_fetch_array($result);
        return $result[0];
    }

    function featured_users($type)
    {
        $result = mysqli_query($this->connection,"SELECT 'Movie' AS type, id,title,release_year,thumbnail,part_1_id,part,category FROM movies WHERE watchable = 'active' AND feature LIKE '%$type%' UNION SELECT 'Webseries', id,title,release_year,thumbnail,part_1_id,season_number,category FROM webseries WHERE watchable = 'active' AND feature LIKE '%$type%' UNION SELECT 'Episode', id,title,release_year,thumbnail,season_number,episode_number,webseries_id FROM webseries_seasons WHERE watchable = 'active' AND feature LIKE '%$type%'");
        return $result;
    }
    
    function free_shows()
    {
        $result = mysqli_query($this->connection,"SELECT 'Movie' AS type, id,title,release_year,thumbnail,part_1_id,part,category FROM movies WHERE watchable = 'active' AND status = 'free' UNION SELECT 'Webseries', id,title,release_year,thumbnail,part_1_id,season_number,category FROM webseries WHERE watchable = 'active' AND status = 'free' UNION SELECT 'Episode', id,title,release_year,thumbnail,season_number,episode_number,webseries_id FROM webseries_seasons WHERE watchable = 'active' AND status = 'free' LIMIT 10");
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

    function check_free_or_not($table,$id){
        $result = mysqli_query($this->connection,"SELECT status FROM $table WHERE id = '$id'");
        $result = mysqli_fetch_array($result);
        return $result[0];
    }
}