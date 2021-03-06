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
$ratings = '';
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

if(isset($_GET['ratings']))
{
    $ratings = $_GET['ratings'];
}

if($type == 'movie')
{
    $movies_result = $Movie->get_all_movies_by_query($search,$letter,$year,$order,$category,$page_number,$ratings);
    $response = array();
    while ($row = mysqli_fetch_assoc($movies_result[0])) {
        array_push($response,$row);
    }
    $total_response = mysqli_num_rows($movies_result[1]);
    $total_response = $Movie->calcPagination($total_response);
    array_push($response,$total_response);
    if(count($response)>1){
        echo json_encode($response);
    }else{
        echo json_encode([]);
    }
}else{
    $webseries_result = $Webseries->get_all_webseries_by_query($search,$letter,$year,$order,$category,$page_number,$ratings);
    $response = array();
    while ($row = mysqli_fetch_assoc($webseries_result[0])) {
        $all_data = array("webseries"=>$row);
        array_push($response,$all_data);
    }
    $total_response = mysqli_num_rows($webseries_result[1]);
    $total_response = $Webseries->calcPagination($total_response);
    array_push($response,$total_response);
    if(count($response)>1){
        echo json_encode($response);
    }else{
        echo json_encode([]);
    }
}