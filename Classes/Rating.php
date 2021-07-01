<?php

class Rating
{
    public $connection;

    function __construct($connection)
    {
        $this->connection = $connection;
    }

    function getAllReviews($video_id,$type){
        $result = mysqli_query($this->connection,"SELECT * FROM rating_review WHERE video_id = '$video_id' AND type = '$type' AND comment != ''");
        return $result;
    }

    function addRating($video_id,$user_id,$star,$comment,$type){
        $userCheckResult = $this->checkUserRated($video_id,$user_id,$type);
        if($userCheckResult){
            $result = mysqli_query($this->connection,"INSERT INTO rating_review (video_id,user_id,star,comment,type) VALUE ('$video_id','$user_id','$star','$comment','$type')");
            if($result)
                return true;
        }else{
            $result = mysqli_query($this->connection,"UPDATE rating_review SET star = '$star' , comment = '$comment' WHERE video_id = '$video_id' AND user_id = '$user_id' AND type = '$type'");
            if($result)
                return true;
        }
    }

    function getRatedDetails($video_id,$user_id,$type){
        $result = mysqli_query($this->connection,"SELECT * FROM rating_review WHERE video_id = '$video_id' AND user_id = '$user_id' AND type = '$type'");
        return $result;
    }

    function checkUserRated($video_id,$user_id,$type){
        $result = mysqli_query($this->connection,"SELECT * FROM rating_review WHERE video_id = '$video_id' AND user_id = '$user_id' AND type = '$type'");
        if(mysqli_num_rows($result)<1){
            return true;
        }else{
            return false;
        }
    }

    function calculateTotRating($video_id,$type){
        $result = mysqli_query($this->connection,"SELECT * FROM rating_review WHERE video_id = '$video_id' AND type = '$type'");
        $total_no_of_users_rated = mysqli_num_rows($result);
        $totatl_rating = 0;
        while($row = mysqli_fetch_assoc($result)){
            $totatl_rating+=$row['star'];
        }
        if($totatl_rating > 0){
            $avg_rating = round($totatl_rating/$total_no_of_users_rated,2);
        }else{
            $avg_rating = 0;
        }
        return [$avg_rating,$total_no_of_users_rated];
    }
}
