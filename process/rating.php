<?php
session_start();
include "../includes/db.php";
include_once "../Classes/Rating.php";
$Rating = new Rating($connection);
include_once "../Classes/Dashboard.php";
$Dashboard = new Dashboard($connection);
include_once "../Classes/User.php";
$User = new User($connection);
if(isset($_POST['review_id'])){
    $id = $_POST['review_id'];
    $Rating->deleteReview($id);
    echo 1; 
}else{
    $user_id = $_POST['user_id'];
    $video_id = $_POST['video_id'];
    $type = $_POST['type'];
    $star = $_POST['star'];
    $comment = filter_var(trim($_POST['comment']), FILTER_SANITIZE_STRING);

    if(isset($_SESSION['user_id']))
    {
        $check_free_or_not = $Dashboard->check_free_or_not('movies',$video_id);
        if($check_free_or_not == 'free' || $User->check_account_is_premium($_SESSION['user_id']) === false)
        {
            $Rating->addRating($video_id,$user_id,$star,$comment,$type);
            $ratings = $Rating->calculateTotRating($video_id,$type);
            echo json_encode($ratings);
        }else{
            echo json_encode("not-paid");
        }
    }else{
        echo json_encode("not-loggedin");
    }
}