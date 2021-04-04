<?php
include_once "../includes/db.php";
include_once "../../Classes/Category.php";
$Category = new Category($connection);
$categories = $Category->get_all_category_admin();

$output = '';

$output.="<form action='' class='form-wrapper'>
<div class='main-content'>
    <div class='main-content-left form-group'>
        <div class='d-flex'>
            <input type='text' id='movie-title' class='form-control' placeholder='Enter Movie Title' required>
            <select id='movie-part'>
            ";
            for($i=1;$i<=50;$i++){
                $output.="<option value='{$i}'>Part {$i}</option>";
            }

        $output.="
        </select>
        </div>
        <br>
        <textarea type='text' id='movie-description' class='form-control' placeholder='Add description'></textarea>
        <br>
        <div class='d-flex'>
        <select class='form-control' id='category-select'>
        <option value='0'>Select category</option>";
            
            while($row = mysqli_fetch_assoc($categories)){
                $output.="<option value='{$row['id']}'>{$row['category']}</option>";
            }

        $output.="</select>
        <div class='btn btn-success' id='add-category'>Add</div>
        </div>
        <div class='input-selected-tags selected-categories'></div>
        <br>
        <input type='number' id='movie-age' class='form-control' placeholder='Enter age'>
        <br>
            <select id='movie-status' class='form-control'>
                <option value='paid' selected>Paid</option>
                <option value='free'>Free</option>
            </select>
    </div>
    <div class='main-content-right form-group'>
        <input type='text' id='movie-thumbnail' class='form-control' placeholder='Add Thumbnail'>
        <br>
        <div class='link-add-wrapper'>
        <div class='d-flex justify-content-around my-2'><span class='current-link' id='video-link'>Video link</span><span id='video-iframe'>Iframe</span></div>
            <input type='text' id='movie-link' class='form-control movie-link-input vedio-link-tab' placeholder='Enter link'>
            <textarea type='text' id='movie-iframe' class='form-control d-none movie-link-input vedio-iframe-tab' placeholder='Enter Embeded code'></textarea>
        </div>
        <br>
        <input type='number' id='movie-year' class='form-control' placeholder='Released year'>
        <br>
        <input type='number' id='movie-duration' class='form-control' placeholder='Enter duration in minutes'>
        <br>
            <select id='movie-language' class='form-control' placeholder='Select part number'>";
            $result = mysqli_query($connection,"SELECT language FROM language");
            while($row = mysqli_fetch_assoc($result))
            {
                $output.="<option value='{$row['language']}'>{$row['language']}</option>";
            }
            $output.="</select>
    </div>
</div>
<button class='btn btn-primary' id='publish-movie'>Publish</button>
</form>";
// $output.="<script type='text/javascript' src='../assets/js/add-movies.js' async></script>";

echo $output;