<?php
include_once "../includes/db.php";
include_once "../../Classes/Category.php";
include_once "../../Classes/Movie.php";
$Category = new Category($connection);
$Movies = new Movie($connection);

$movie_id = $_POST['movie_id'];
$data_array = array();
$categories = $Category->selected_categories_movies($movie_id);

$movies = $Movies->get_all_movies_by_id($movie_id);
while ($row = mysqli_fetch_assoc($movies)) {
    $category_array = array();
    
    while($category = mysqli_fetch_assoc($categories))
    {
       $category_db = $Category->get_category_by_id($category['category_id']);
       $category_fetched = mysqli_fetch_assoc($category_db);
       $data_category = array("id"=>$category['category_id'],"category"=>$category_fetched['category']);
       array_push($category_array,$data_category);
    }
    array_push($data_array,$row,$category_array);
}

echo json_encode($data_array);