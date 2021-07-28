<?php
include "../includes/db.php";

$search = $_POST['search'];

$result = mysqli_query($connection,"SELECT 'Movie' AS type, id,title,release_year,thumbnail,language,part FROM movies WHERE watchable = 'active' AND title LIKE '%$search%' UNION SELECT 'Webseries', id,title,release_year,thumbnail,language,season_number FROM webseries WHERE watchable = 'active' AND title LIKE '%$search%'");

$row = mysqli_fetch_all($result);
echo json_encode($row);