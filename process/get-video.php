<?php
session_start();
include "../includes/db.php";
include_once "../Classes/Movie.php";
$Movie = new Movie($connection);
include_once "../Classes/Webseries.php";
$Webseries = new Webseries($connection);
include_once "../Classes/Dashboard.php";
$Dashboard = new Dashboard($connection);
include_once "../Classes/User.php";
$User = new User($connection);
$id = $_POST['id'];
$type = $_POST['type'];

if($type == 'movie')
{
   if(isset($_SESSION['user_id']))
   {
$check_free_or_not = $Dashboard->check_free_or_not('movies',$id);
      if($check_free_or_not == 'free' || $User->check_account_is_premium($_SESSION['user_id']) === false)
      {
         if($Movie->get_movie_by_id_and_search('iframe',$id) != '')
            {
               echo $Movie->get_movie_by_id_and_search('iframe',$id);
            }else{
               echo "<video type='video/webm' style='width:100%;height:100%;' autoplay controls src='{$Movie->get_movie_by_id_and_search('link',$id)}'></video>";
            }
      }else{
         echo "not-paid";
      }
   }else{
      echo "not-loggedin";
   }
}else if($type == 'webseries')
{
   if(isset($_SESSION['user_id']))
   {
   $episode_id = $_POST['episode_id'];
   $check_free_or_not = $Dashboard->check_free_or_not('webseries_seasons',$episode_id);
   if($check_free_or_not == 'free' || $User->check_account_is_premium($_SESSION['user_id']) === false)
      {
      if($Webseries->get_webseries_episode_by_id_and_search('iframe',$episode_id) != '')
         {
            echo $Webseries->get_webseries_episode_by_id_and_search('iframe',$episode_id);
         }else{
            echo "<video type='video/webm' style='width:100%;height:100%;' autoplay controls src='{$Webseries->get_webseries_episode_by_id_and_search('link',$episode_id)}'></video>";
         }
   }else{
         echo "not-paid";
      }
   }else{
      echo "not-loggedin";
   }
}else if($type == 'episode')
{
   $all_episodes = $Webseries->get_first_episode_of_webseries($id);
   $all_episodes = mysqli_fetch_assoc($all_episodes);
   echo $all_episodes['id'];
}else if($type == 'webseries_name')
{
   $title = $Webseries->get_webseries_by_id_and_search('title',$id);
   echo $title;
}