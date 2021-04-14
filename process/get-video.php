<?php
include "../includes/db.php";
include_once "../Classes/Movie.php";
$Movie = new Movie($connection);
include_once "../Classes/Webseries.php";
$Webseries = new Webseries($connection);
$id = $_POST['id'];
$type = $_POST['type'];

if($type == 'movie')
{
   if($Movie->get_movie_by_id_and_search('iframe',$id) != '')
      {
         echo $Movie->get_movie_by_id_and_search('iframe',$id);
      }else{
         echo "<video type='video/webm' style='width:100%;height:100%;' autoplay controls src='{$Movie->get_movie_by_id_and_search('link',$id)}'></video>";
      }
}else if($type == 'webseries')
{
   $episode_id = $_POST['episode_id'];
   if($Webseries->get_webseries_episode_by_id_and_search('iframe',$id) != '')
      {
         echo $Webseries->get_webseries_episode_by_id_and_search('iframe',$id);
      }else{
         echo "<video type='video/webm' style='width:100%;height:100%;' autoplay controls src='{$Webseries->get_webseries_episode_by_id_and_search('link',$id)}'></video>";
      }
}