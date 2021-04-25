<?php
include "../includes/db.php";
include_once "../Classes/Dashboard.php";
$Dashboard = new Dashboard($connection);
$feature = $_GET['feature'];

$home_featured = $Dashboard->featured_users($feature);
$feature_array = [];

while($row = mysqli_fetch_assoc($home_featured))
{
    array_push($feature_array,$row);
}
echo json_encode($feature_array);