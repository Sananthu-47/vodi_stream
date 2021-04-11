<?php
include_once "../includes/db.php";
include_once "../../Classes/Movie.php";
include_once "../../Classes/Webseries.php";
$Movies = new Movie($connection);
$Webseries = new Webseries($connection);

$movie_id = $_POST['movie_id'];
$type = $_POST['type'];
$data_array = array();
$data = '';

if($type == 'movie')
{
    $data = $Movies->get_all_movies_by_id($movie_id);
} else if($type == 'webseries')
{
    $data = $Webseries->get_webseries_by_id($movie_id);
}

while ($row = mysqli_fetch_assoc($data)) {
    $categories = explode(',',$row['category']);
    $category_array = array();
    foreach ($categories as $key => $category)
    {
    $data_category = array("category"=>$category);
    array_push($category_array,$data_category);
    }
    array_push($data_array,$row,$category_array);
}

echo json_encode($data_array);