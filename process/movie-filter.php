<?php
include "../includes/db.php";
include_once "../Classes/Movie.php";
$Movie = new Movie($connection);
$search = '';
$letter = '';
$year = '';
$order = '';

if(isset($_GET['search']))
{
    $search = $_GET['search'];
}

if(isset($_GET['letter']))
{
    $letter = $_GET['letter'];
}

if(isset($_GET['year']))
{
    $year = $_GET['year'];
}

if(isset($_GET['order']))
{
    $order = $_GET['order'];
}

$movies_result = $Movie->get_all_movies_by_query($search,$letter,$year,$order);
$response = array();
while ($row = mysqli_fetch_assoc($movies_result)) {
    array_push($response,$row);
}
echo json_encode($response);