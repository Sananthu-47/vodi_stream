<?php
include_once "../includes/db.php";
include "../../Classes/Webseries.php";
$Webseries = new Webseries($connection);

$webseries_id = $_POST['part_1'];
$action = $_POST['action'];
$episode_error = '';
$erorr_array = [];

if(strlen($_POST['episodes'])<3)
{
    $episode_error = 0;
}else{
    $episodes = $_POST['episodes'];
}

if($episode_error===0)
{
    echo 'episode';
}else 
if($action == 'publish'){
    $response = $Webseries->add_webseries_season($webseries_id,$episodes,'paid');
    echo 'success';
}else 
if($action == 'update'){
    // $id = $_POST['id'];
    // $end_year = $_POST['end_year'];
    // $response = $Webseries->update_webseries($id,$title,$season,$part_1,$age,$thumbnail,$description,$status,$year,$language,$categories,$end_year);
    // if($response)
    // {
    //     echo "success";
    // }
}
