<?php
include_once "../includes/db.php";
include "../../Classes/Webseries.php";
$Webseries = new Webseries($connection);
include "../../Classes/Category.php";
$Category = new Category($connection);

$title = $_POST['title'];
$season = $_POST['season'];
$part_1 = $_POST['part_1'];
$age = $_POST['age'];
$thumbnail = $_POST['thumbnail'];
$description = $_POST['description'];
$status = $_POST['status'];
$year = $_POST['year'];
$language = $_POST['language'];
$action = $_POST['action'];
$episode_error = '';
$category_error = '';
$erorr_array = [];

if(isset($_POST['category_array']))
{
$categories = $_POST['category_array'];
}else{
    $category_error = 0;
}

if(strlen($_POST['episodes'])<3)
{
    $episode_error = 0;
}else{
    $episodes = $_POST['episodes'];
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
if($language=='')
{
    array_push($erorr_array,6);
}
if($category_error===0)
{
    array_push($erorr_array,7);
}

if(count($erorr_array)>0)
{
    echo json_encode($erorr_array);
}else
if($episode_error===0)
{
    echo 'episode';
}else 
if($action == 'publish'){
    $webseries_id = $Webseries->add_webseries($title,$season,$part_1,$age,$thumbnail,$description,$status,$year,$language,$categories);
    $response = $Webseries->add_webseries_season($webseries_id,$episodes,$status);
    if($response)
    {
        echo 'success';
    }
}else 
if($action == 'update'){
    $id = $_POST['id'];
    $end_year = $_POST['end_year'];
    $response = $Webseries->update_webseries($id,$title,$season,$part_1,$age,$thumbnail,$description,$status,$year,$language,$categories,$end_year);
    if($response)
    {
        echo "success";
    }
}
