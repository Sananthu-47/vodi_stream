<?php
class Advertisement{

    public $connection;

    function __construct($connection)
    {
        $this->connection = $connection;
    }

    function get_advertisement_to_video($id,$type){
        $result = mysqli_query($this->connection,"SELECT * FROM advertisements WHERE video_id = '$id' AND video_type = '$type'");
        return $result;
    }

    function delete_advertisement($id){
        $result = mysqli_query($this->connection,"DELETE FROM advertisements WHERE id = '$id'");
        return $result;
    }

    function add_advertisement($new_array){
        foreach ($new_array as $key => $value) {
            mysqli_query($this->connection,"INSERT INTO advertisements (video_id,video_type,link) VALUES ('{$value['video_id']}' , '{$value['video_type']}' , '{$value['link']}')");
        }
        return true;
    }

    function get_videos_with_ads(){
        $result = mysqli_query($this->connection,"SELECT video_id,video_type, COUNT(video_id) FROM advertisements GROUP BY video_id , video_type ORDER BY id");
        return $result;
    }
}