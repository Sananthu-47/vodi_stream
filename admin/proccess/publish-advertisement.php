<?php
include_once "../includes/db.php";
include "../../Classes/Advertisement.php";
$Advertisement = new Advertisement($connection);
$old_array = [];
$new_array = [];
if(isset($_POST['added_ads_array'])){
    $old_array = $_POST['added_ads_array'];
}
if(isset($_POST['new_ads_array'])){
    $new_array = $_POST['new_ads_array'];
}
$deleted = '';

foreach ($old_array as $key => $value) {
    $result = in_array($value,$new_array);
    if($result == false){
        $Advertisement->delete_advertisement($value['id']);
        $deleted = 1;
    }else{
        $found_key = array_search($value,$new_array);
        unset($new_array[$found_key]);
    }
}

if(count($new_array) > 0){
    $response = $Advertisement->add_advertisement($new_array);
    if($response){
        echo 1;
    }
}else if($deleted == 1){
    echo 2;
}else{
    echo 0;
}