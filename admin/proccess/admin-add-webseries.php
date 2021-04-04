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
            <input type='text' id='webseries-title' class='form-control' placeholder='Enter Webseries Title' required>
            <select id='webseries-season' disabled>
            <option value='1' selected>Season 1</option>
            </select>
        </div>
        <br>
        <textarea type='text' id='webseries-description' class='form-control' placeholder='Add description'></textarea>
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
        <input type='number' id='webseries-age' class='form-control' placeholder='Enter age'>
        <br>
            <select id='webseries-status' class='form-control'>
                <option value='paid' selected>Paid</option>
                <option value='free'>Free</option>
            </select>
            <br>
            <input type='text' id='webseries-thumbnail' class='form-control' placeholder='Add Thumbnail'>
            <br>
            <input type='number' id='webseries-year' class='form-control' placeholder='Released year'>
        <br>
            <select id='webseries-language' class='form-control'>";
            $result = mysqli_query($connection,"SELECT language FROM language");
            while($row = mysqli_fetch_assoc($result))
            {
                $output.="<option value='{$row['language']}'>{$row['language']}</option>";
            }
            $output.="</select>
    </div>
    <div class='main-content-right form-group'>
        <div class='link-add-wrapper'>
            <div class='d-flex justify-content-around my-2'><span class='current-link' id='video-link'>Video link</span><span id='video-iframe'>Iframe</span></div>
            <div class='responsive-flex'>
                <input type='text' id='webseries-link' class='form-control movie-link-input vedio-link-tab my-1' placeholder='Enter link'>
                <textarea type='text' id='webseries-iframe' class='form-control movie-link-input vedio-iframe-tab my-1 d-none' placeholder='Enter Embeded code'></textarea>
                <input type='text' id='episode-title' class='form-control my-1' placeholder='Enter title'>
                <select id='webseries-episode' class='form-control my-1'>
                    <option value='0'>Select episode</option>";
                    for($i=1;$i<=200;$i++){
                        $output.="<option value='{$i}'>Episode {$i}</option>";
                    }
                    $output.="
                </select>
                <textarea type='text' id='episode-description' class='form-control my-1' placeholder='Enter the episode description'></textarea>
                <input type='text' id='episode-thumbnail' class='form-control my-1' placeholder='Add Thumbnail'>
                <input type='number' id='episode-year' class='form-control my-1' placeholder='Year of release'>
                <input type='number' id='episode-duration' class='form-control my-1' placeholder='Add duration in minutes'>
                <div class='btn btn-success my-1 px-5' id='add-episode'>Add</div>
            </div>
        </div><!--link-add-wrapper-->

        <div class='input-selected-tags added-episodes'></div>
        <br>

    </div>
</div>
<button class='btn btn-primary' id='publish-webseries'>Publish</button>
</form>";

// $output.="<script type='text/javascript' src='../assets/js/add-webseries.js' async></script>";

echo $output;

