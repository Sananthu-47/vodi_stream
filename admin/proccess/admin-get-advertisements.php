<?php
include_once "../includes/db.php";
include_once "../../Classes/Advertisement.php";
$Advertisement = new Advertisement($connection);

$video_id = $_POST['video_id'];
$type = $_POST['type'];
$data_array = array();
$data = '';

if($type == 'movie')
{
    $data = $Advertisement->get_advertisement_to_video($video_id,$type);
} else if($type == 'episode')
{
    $data  = $Advertisement->get_advertisement_to_video($video_id,$type);
}

while ($row = mysqli_fetch_assoc($data)) {
    array_push($data_array,$row);
}

echo json_encode($data_array);