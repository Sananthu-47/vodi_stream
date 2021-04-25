<?php
include_once "../includes/db.php";
include_once "../../Classes/Dashboard.php";
include_once "../../Classes/Movie.php";
include_once "../../Classes/Webseries.php";
$Dashboard = new Dashboard($connection);
$Movie = new Movie($connection);
$Webseries = new Webseries($connection);
$type = $_POST['type'];
$action = $_POST['action'];
$result = '';
$data_array = array();

if($action == 'get')
{
    $result = $Dashboard->featured($type);
    if(mysqli_num_rows($result)<1)
    {
        return 0;
    }else{
        while($row = mysqli_fetch_assoc($result))
        {
            array_push($data_array,$row);
        }
        echo json_encode($data_array);
    }
}else if($action == 'add')
{
    $id = $_POST['id'];
    $feature = $_POST['feature'];
    $result = $Dashboard->addTo($type,$id,$feature);
        $response = $Dashboard->featured($feature);
        if(mysqli_num_rows($response)<1)
        {
            return 0;
        }else{
            while($row = mysqli_fetch_assoc($response))
            {
                array_push($data_array,$row);
            }
            echo json_encode($data_array);
        }
}else if($action == 'delete')
{

    $id = $_POST['id'];
    $feature = $_POST['feature'];
    if($type == 'Movie')
    {
        $feature_db = $Movie->get_movie_by_id_and_search('feature',$id);
    }else if($type == 'Webseries')
    {
        $feature_db = $Webseries->get_webseries_by_id_and_search('feature',$id);
    }else if($type == 'Episode')
    {
        $feature_db = $Webseries->get_webseries_episode_by_id_and_search('feature',$id);
    }
    $feature_db = explode(',',$feature_db);
    if(in_array($feature,$feature_db))
    {
        $feature_db = array_diff($feature_db,array($feature));
    }
    $output = '';
    foreach ($feature_db as $key => $value) {
        if(count($feature_db)<=1)
        {
            $output = $value;
        }else{
            if($key <= count($feature_db)-1)
            {
                $output.=$value.',';
            }else{
                $output.=$value;
            }
        }
    }
    $result = $Dashboard->delete_from_feature($type,$id,$output);

    $response = $Dashboard->featured($feature);
        if(mysqli_num_rows($response)<1)
        {
            return 0;
        }else{
            while($row = mysqli_fetch_assoc($response))
            {
                array_push($data_array,$row);
            }
            echo json_encode($data_array);
        }
}