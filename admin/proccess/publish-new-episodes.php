<?php
include_once "../includes/db.php";
include "../../Classes/Webseries.php";
$Webseries = new Webseries($connection);
$action = $_POST['action'];

if($action == 'update'){
    $id = $_POST['id'];
    $link = $_POST['link'];
    $iframe = $_POST['iframe'];
    $title = $_POST['title'];
    $episode_part = $_POST['episode_part'];
    $thumbnail = $_POST['thumbnail'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $year = $_POST['year'];
    $duration = $_POST['duration'];
    $response = $Webseries->update_webseries_episode($id,$title,$link,$iframe,$thumbnail,$episode_part,$description,$status,$year,$duration);
    if($response)
    {
        echo "success";
    }
}else{
    $webseries_id = $_POST['part_1'];
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
    }
}