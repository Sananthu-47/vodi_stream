<?php
include_once "../includes/db.php";
include "../../Classes/Webseries.php";
$Webseries = new Webseries($connection);
include "../../Classes/Category.php";
$Category = new Category($connection);

$title = $_POST['title'];
$age = $_POST['age'];
$thumbnail = $_POST['thumbnail'];
$description = $_POST['description'];
$status = $_POST['status'];
$year = $_POST['year'];
$language = $_POST['language'];
$episode_error = '';
$category_error = '';
$erorr_array = [];

if(isset($_POST['category_array_db']))
{
$categories = $_POST['category_array_db'];
}else{
    $category_error = 0;
}

if(isset($_POST['episodes']))
{
$episodes = $_POST['episodes'];
}else{
    $episode_error = 0;
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
}
else{
    $webseries_id = $Webseries->add_webseries($title,$age,$thumbnail,$description,$status,$year,$language);
    $Webseries->add_webseries_season($webseries_id,$episodes,$status);
    $Category->add_selected_categories_webseries($categories,$webseries_id);
    echo 'success';
}