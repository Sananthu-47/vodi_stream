<?php
include_once "../includes/db.php";
include_once "../../Classes/Category.php";
include_once "../../Classes/Movie.php";
$Category = new Category($connection);
$categories = $Category->get_all_category_admin();
$Movies = new Movie($connection);

$part = $_POST['part'];
$search = $_POST['search'];
$language = $_POST['language'];
$data_array = array();

$movies = $Movies->get_all_movies_with_query($part,$search,$language);
while($row = mysqli_fetch_assoc($movies))
{
    array_push($data_array,$row);
}

echo json_encode($data_array);