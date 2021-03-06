<?php
include_once "../includes/db.php";
include_once "../../Classes/Movie.php";
include_once "../../Classes/Webseries.php";
$Movies = new Movie($connection);
$Webseries = new Webseries($connection);

$part = $_POST['part'];
$search = $_POST['search'];
$language = $_POST['language'];
$type = $_POST['type'];
$feature = $_POST['feature'];
$data_array = array();

if($type == 'movie')
{
    $movies = $Movies->get_all_movies_with_non_feature($part,$search,$language,$feature);
    while($row = mysqli_fetch_assoc($movies))
    {
        array_push($data_array,$row);
    }
}else if($type == 'webseries')
{
    $webseries = $Webseries->get_all_webseries_with_non_feature($part,$search,$language,$feature);
    while($row = mysqli_fetch_assoc($webseries))
    {
        array_push($data_array,$row);
    }
}else if($type == 'episode')
{
    $webseries = $Webseries->get_all_episode_with_non_feature($part,$search,$language,$feature);
    while($row = mysqli_fetch_assoc($webseries))
    {
        array_push($data_array,$row);
    }
}

echo json_encode($data_array);