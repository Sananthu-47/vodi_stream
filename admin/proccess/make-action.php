<?php
include_once "../includes/db.php";
$id = $_POST['id'];
$action = $_POST['action'];

switch ($action) {
    case 'movie-active':
        $result = mysqli_query($connection,"UPDATE movies SET watchable = 'active' WHERE id = '$id'");
        break;
    case 'movie-block':
        $result = mysqli_query($connection,"UPDATE movies SET watchable = 'blocked' WHERE id = '$id'");
        break;
    case 'webseries-active':
        $result = mysqli_query($connection,"UPDATE webseries SET watchable = 'active' WHERE id = '$id'");
        $result = mysqli_query($connection,"UPDATE webseries_seasons SET watchable = 'active' WHERE webseries_id = '$id'");
        break;
    case 'webseries-block':
        $result = mysqli_query($connection,"UPDATE webseries SET watchable = 'blocked' WHERE id = '$id'");
        $result = mysqli_query($connection,"UPDATE webseries_seasons SET watchable = 'blocked' WHERE webseries_id = '$id'");
        break;
    case 'episode-active':
        $result = mysqli_query($connection,"UPDATE webseries_seasons SET watchable = 'active' WHERE id = '$id'");
        break;
    case 'episode-block':
        $result = mysqli_query($connection,"UPDATE webseries_seasons SET watchable = 'blocked' WHERE id = '$id'");
        break;
    case 'user-active':
        $result = mysqli_query($connection,"UPDATE users SET status = 'active' WHERE id = '$id'");
        break;
    case 'user-block':
        $result = mysqli_query($connection,"UPDATE users SET status = 'blocked' WHERE id = '$id'");
        break;
    case 'movie-delete':
        $result = mysqli_query($connection,"UPDATE movies SET watchable = 'deleted' WHERE id = '$id'");
        break;
    case 'webseries-delete':
        $result = mysqli_query($connection,"UPDATE webseries SET watchable = 'deleted' WHERE id = '$id'");
        break;
    case 'webseries-episode-delete':
        $result = mysqli_query($connection,"UPDATE webseries_seasons SET watchable = 'deleted' WHERE id = '$id'");
        break;
    case 'user-delete':
        $result = mysqli_query($connection,"UPDATE users SET status = 'deleted' WHERE id = '$id'");
        break;
    
    default:
        echo false;
        break;
}
