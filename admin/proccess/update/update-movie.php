<?php
include_once "../includes/db.php";
include_once "../../Classes/Movie.php";
include_once "../../Classes/Category.php";
$Category = new Category($connection);
$categories = $Category->get_all_category_admin();
$Movie = new Movie($connection);
$movies = $Movie->get_all_movies_by_id($movie_id);
$movie_data = mysqli_fetch_assoc($movies);

$output = '';

$output.="<form action='' class='form-wrapper'>
<div class='main-content'>
    <div class='main-content-left form-group'>
    <label class='badge badge-dark'>Movie title:</label>
        <div class='d-flex'>
            <input type='text' id='movie-title' class='form-control' placeholder='Enter Movie Title' value='{$movie_data['title']}' required>
            <select class='movie-part' data-type='movie'>
            ";
            for($i=1;$i<=50;$i++){
                $output.="<option value='{$i}'";
                if($i == $movie_data['part'])
                {
                    $output.='selected';
                }
                $output.=">Part {$i}</option>";
            }

        $output.="
        </select>
        </div>
        <br>
        <label class='badge badge-dark'>Add description:</label>
        <textarea type='text' id='movie-description' class='form-control' placeholder='Add description'>{$movie_data['description']}</textarea>
        <br>
        <label class='badge badge-dark'>Select categories:</label>
        <div class='d-flex'>
        <select class='form-control' id='category-select'>
        <option value='0'>Select category</option>";
            
            while($row = mysqli_fetch_assoc($categories)){
                $output.="<option value='{$row['id']}'>{$row['category']}</option>";
            }

        $output.="</select>
        <div class='btn btn-success' id='add-category'>Add</div>
        </div>
        <div class='input-selected-tags selected-categories'>
            <div class='all-categories-name'>{$movie_data['category']}</div>
        </div>
        <br>
        <label class='badge badge-dark'>Age:</label>
        <input type='number' id='movie-age' class='form-control' value='{$movie_data['age']}' placeholder='Enter age'>
        <br>
        <label class='badge badge-dark'>Movie status:</label>
            <select id='movie-status' class='form-control'>
                <option value='paid'";
                if('paid' == $movie_data['status'])
                {
                    $output.='selected';
                }
                $output.=">Paid</option>
                <option value='free'";
                if('free' == $movie_data['status'])
                {
                    $output.='selected';
                }
                $output.=">Free</option>
            </select>
    </div>
    <div class='main-content-right form-group'>
    <label class='badge badge-dark'>Thumbnail</label>
        <input type='text' id='movie-thumbnail' class='form-control' value='{$movie_data['thumbnail']}' placeholder='Add Thumbnail'>
        <br>
        <div class='link-add-wrapper'>
        <div class='d-flex justify-content-around my-2'><span class='current-link' id='video-link'>Video link</span><span id='video-iframe'>Iframe</span></div>
            <input type='text' id='movie-link' value='{$movie_data['link']}' class='form-control movie-link-input vedio-link-tab' placeholder='Enter link'>
            <textarea type='text' id='movie-iframe' class='form-control d-none movie-link-input vedio-iframe-tab' placeholder='Enter Embeded code'>{$movie_data['iframe']}</textarea>
        </div>
        <br>
        <label class='badge badge-dark'>Released Year:</label>
        <input type='number' id='movie-year' value='{$movie_data['release_year']}' class='form-control' placeholder='Released year'>
        <br>
        <label class='badge badge-dark'>Duration:</label>
        <input type='number' id='movie-duration' value='{$movie_data['duration']}' class='form-control' placeholder='Enter duration in minutes'>
        <br>
        <label class='badge badge-dark'>Language:</label>
            <select id='movie-language' class='form-control'>";
            $result = mysqli_query($connection,"SELECT language FROM language");
            while($row = mysqli_fetch_assoc($result))
            {
                $output.="<option value='{$row['language']}'";
                if($movie_data['language'] == $row['language'])
                {
                    $output.="selected";
                }
                $output.=">{$row['language']}</option>";
            }
            $output.="</select>
    </div>
</div>
<button class='btn btn-primary add-to-db' data-id='$movie_id' value='{$movie_data['part_1_id']}' id='update-movie'>Update</button>
</form>";

echo $output;