<?php
include_once "../includes/db.php";
include_once "../../Classes/Category.php";
$Category = new Category($connection);
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
    case 'add-category':
        $category_name = $_POST['category_name'];
        $category_number = $Category->check_category_exists($category_name);
        $category_number = mysqli_num_rows($category_number);
        if($category_number<1){
            $result = mysqli_query($connection,"INSERT INTO category (category) VALUE ('$category_name')");
        }else{
        echo 1;
        }
        break;
    case 'delete-category':
        $result = mysqli_query($connection,"DELETE FROM category WHERE id = '$id'");
        break;
    case 'update-category':
        $category_name = $_POST['category_name'];
        $category_number = $Category->check_category_exists($category_name);
        $category_number = mysqli_num_rows($category_number);
        if($category_number<1){
            $result = mysqli_query($connection,"UPDATE category SET category = '$category_name' WHERE id = '$id'");
        }else{
            echo 1;
        }
        break;
    case 'update-payment':
        $result = mysqli_query($connection,"UPDATE package SET price = '{$_POST['monthly']}' WHERE package = 'monthly'");
        $result = mysqli_query($connection,"UPDATE package SET price = '{$_POST['quarterly']}' WHERE package = 'quarterly'");
        $result = mysqli_query($connection,"UPDATE package SET price = '{$_POST['half_yearly']}' WHERE package = 'half-yearly'");
        $result = mysqli_query($connection,"UPDATE package SET price = '{$_POST['annually']}' WHERE package = 'annually'");
        break;

    default:
        echo false;
        break;
}