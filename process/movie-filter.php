<?php
include "../includes/db.php";
include_once "../Classes/Movie.php";
include_once "../Classes/Webseries.php";
$Movie = new Movie($connection);
$Webseries = new Webseries($connection);
$search = '';
$letter = '';
$category = '';
$year = '';
$order = '';
$type = $_GET['type'];
$page_number = $_GET['page_number'];

if(isset($_GET['search']))
{
    $search = $_GET['search'];
}

if(isset($_GET['letter']))
{
    $letter = $_GET['letter'];
}

if(isset($_GET['category']))
{
    $category = $_GET['category'];
}

if(isset($_GET['year']))
{
    $year = $_GET['year'];
}

if(isset($_GET['order']))
{
    $order = $_GET['order'];
}

if($type == 'movie')
{
    $movies_result = $Movie->get_all_movies_by_query($search,$letter,$year,$order,$category,$page_number);
    $response = array();
    while ($row = mysqli_fetch_assoc($movies_result)) {
        array_push($response,$row);
    }
    echo json_encode($response);
}else{
    $webseries_result = $Webseries->get_all_webseries_by_query($search,$letter,$year,$order,$category,$page_number);
    $response = array();
    while ($row = mysqli_fetch_assoc($webseries_result)) {
        $all_episodes = $Webseries->get_first_episode_of_webseries($row['id']);
        $all_episodes = mysqli_fetch_assoc($all_episodes);
        $all_data = array("webseries"=>$row,"episodes"=>$all_episodes);
        array_push($response,$all_data);
    }
    echo json_encode($response);
}