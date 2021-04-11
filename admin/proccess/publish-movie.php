<?php
include_once "../includes/db.php";
include "../../Classes/Movie.php";
$Movie = new Movie($connection);

$title = $_POST['title'];
$age = $_POST['age'];
$thumbnail = $_POST['thumbnail'];
$description = $_POST['description'];
$status = $_POST['status'];
$year = $_POST['year'];
$part = $_POST['part'];
$part_1 = $_POST['part_1'];
$movie_link = $_POST['movie_link'];
$movie_iframe = $_POST['movie_iframe'];
$duration = $_POST['duration'];
$language = $_POST['language'];
$action = $_POST['action'];
$category_error = '';
$erorr_array = [];

if(isset($_POST['category_array']))
{
$categories = $_POST['category_array'];
}else{
    $category_error = 0;
}

if($title=='') 
{
    array_push($erorr_array,0);
}
if($age=='')
{
    array_push($erorr_array,1);
}
if($thumbnail=='') 
{
    array_push($erorr_array,2);
}
if($description=='') 
{
    array_push($erorr_array,3);
}
if($status=='')
{
    array_push($erorr_array,4);
}
if($year=='') 
{
    array_push($erorr_array,5);
}
if($part=='')
{
    array_push($erorr_array,6);
}
if($movie_link=='')
{
    array_push($erorr_array,7);
}
if($movie_iframe=='')
{
    array_push($erorr_array,8);
}
if($duration=='')
{
    array_push($erorr_array,9);
}
if($language=='')
{
    array_push($erorr_array,10);
}
if($category_error===0)
{
    array_push($erorr_array,11);
}
if($part_1=='') 
{
    array_push($erorr_array,12);
}
if($movie_link!=='')
{
    $erorr_array = array_values(search_in_array($erorr_array,[8]));
}
if($movie_iframe!=='')
{
    $erorr_array = array_values(search_in_array($erorr_array,[7]));
}

function search_in_array($array,$key)
{
    return array_diff($array,$key);
}

if(count($erorr_array)>0)
{
    echo json_encode($erorr_array);
}else if($action == 'publish'){
    $response = $Movie->add_movie($title,$age,$thumbnail,$description,$status,$year,$part,$part_1,$movie_link,$movie_iframe,$duration,$language,$categories);
    if($response)
    {
        echo "success";
    }
}else if($action == 'update'){
    $id = $_POST['id'];
    $response = $Movie->update_movie($id,$title,$age,$thumbnail,$description,$status,$year,$part,$part_1,$movie_link,$movie_iframe,$duration,$language,$categories);
    if($response)
    {
        echo "success";
    }
}