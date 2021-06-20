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
        
        $result = mysqli_query($this->connection,"UPDATE webseries_seasons SET language ='$language' WHERE webseries_id = '$id'");

        if($result)
        {
            return true;
        }
        if($result)
        {
            return true;
        }
    }

    function add_webseries_season($webseries_id,$episodes,$status){
        $episode_data = json_decode($episodes);
        $language = $this->get_webseries_by_id_and_search('language',$webseries_id);
        foreach ($episode_data as $key => $value) {
        $description = mysqli_real_escape_string($this->connection,$value->description);
        $title = mysqli_real_escape_string($this->connection,$value->title);
        $link = mysqli_real_escape_string($this->connection,$value->link);
        $iframe = mysqli_real_escape_string($this->connection,$value->iframe);
            $result = mysqli_query($this->connection,"INSERT INTO webseries_seasons (webseries_id,title,link,iframe,season_number,episode_number,thumbnail,description,release_year,duration,status,language) VALUES ('$webseries_id' , '$title' , '$link' , '$iframe' , '$value->season' , '$value->episode', '$value->thumbnail', '$description', '$value->year', '$value->duration' , '$status' , '$language')");
        }
    }

    function get_all_webseries_seasons(){
        $result = mysqli_query($this->connection,"SELECT * FROM webseries_seasons WHERE watchable = 'active'");
        return $result;
    }

    function get_all_webseries_seasons_admin(){
        $result = mysqli_query($this->connection,"SELECT * FROM webseries_seasons WHERE watchable != 'deleted'");
        return $result;
    }

    function get_all_webseries_seasons_by_seriesid($id){
        $result = mysqli_query($this->connection,"SELECT * FROM webseries_seasons WHERE watchable = 'active' AND webseries_id = '$id'");
        return $result;
    }

    function get_all_webseries_seasons_by_seriesid_admin($id){
        $result = mysqli_query($this->connection,"SELECT * FROM webseries_seasons WHERE watchable != 'deleted' AND webseries_id = '$id'");
        return $result;
    }

    function get_first_episode_of_webseries($id){
        $result = mysqli_query($this->connection,"SELECT id FROM webseries_seasons WHERE watchable = 'active' AND webseries_id = '$id'");
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

    function get_webseries_by_id_admin($id){
        $result = mysqli_query($this->connection,"SELECT * FROM webseries WHERE watchable != 'deleted' AND id = '$id'");
        return $result;
    }

    function get_webseries_by_id($id){
        $result = mysqli_query($this->connection,"SELECT * FROM webseries WHERE watchable = 'active' AND id = '$id'");
        return $result;
    }

    function get_webseries_by_part_1_id($id){
        $result = mysqli_query($this->connection,"SELECT * FROM webseries WHERE watchable = 'active' AND part_1_id = '$id'");
        return $result;
    }

    function get_webseries_by_id_and_search($get_value,$id)
    {
        $result = mysqli_query($this->connection,"SELECT $get_value FROM webseries WHERE watchable = 'active' AND id = '$id'");
        $row = mysqli_fetch_array($result);
        return $row[0];
    }

    function get_webseries_episode_by_id_and_search($get_value,$id)
    {
        $result = mysqli_query($this->connection,"SELECT $get_value FROM webseries_seasons WHERE watchable = 'active' AND id = '$id'");
        $row = mysqli_fetch_array($result);
        return $row[0];
    }

    function get_all_webseries_with_query($part,$search,$language)
    {
        $db_query = "SELECT * FROM webseries WHERE watchable = 'active'";
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

    function get_all_webseries_with_non_feature($part,$search,$language,$feature)
    {
        $db_query = "SELECT * FROM webseries WHERE watchable = 'active'";
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
        if($feature != '')
        {
            $db_query .= "AND feature NOT LIKE '%$feature%'";
        }
        $db_query .= " ORDER BY title";
        $result = mysqli_query($this->connection,$db_query);
        return $result;
    }

    function get_webseries_letter(){
        $result = mysqli_query($this->connection,"SELECT title FROM webseries WHERE watchable = 'active' ORDER BY title");
        $letter_array = [];
        while($row = mysqli_fetch_assoc($result))
        {
            if(!in_array($row['title'][0],$letter_array))
            {
                array_push($letter_array,$row['title'][0]);
            }
        }
        return $letter_array;
    }

    function get_all_years(){
        $result = mysqli_query($this->connection,"SELECT release_year FROM webseries WHERE watchable = 'active' ORDER BY release_year");
        $year_array = [];
        while($row = mysqli_fetch_assoc($result))
        {
            if(!in_array($row['release_year'],$year_array))
            {
                array_push($year_array,$row['release_year']);
            }
        }
        return $year_array;
    }

    function get_all_webseries_by_query($search,$letters,$years,$order,$categorys,$page_number){
        $query = '';
        $query.="SELECT * FROM webseries WHERE watchable = 'active'";
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
            $no_of_records_per_page = 20;
            $offset = ($page_number-1) * $no_of_records_per_page;
            $total_rows = $this->get_all_webseries_users();
            $total_rows = mysqli_num_rows($total_rows);
            $total_pages = ceil($total_rows / $no_of_records_per_page);
            $query.=" LIMIT $offset, $no_of_records_per_page";
        }
        $result = mysqli_query($this->connection,$query);
        return $result;
    }


    function get_all_episode_with_non_feature($part,$search,$language,$feature)
    {
        $db_query = "SELECT * FROM webseries_seasons WHERE watchable = 'active'";
        if($part != 0)
        {
            $db_query .= "AND episode_number = '$part'";
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

}
