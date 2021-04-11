<?php
include_once "../includes/db.php";
include_once "../../Classes/Category.php";
$Category = new Category($connection);
$categories = $Category->get_all_category_admin();

$output = '';

$output.="
            <div class='part-selection-wrapper' style='display:none'>
                <div class='part-selection'>
                    <div class='text-header'><span>Choose the previous part</span><i class='fa fa-close' id='close-parts'></i></div>
                    <div class='part-select-header'>
                        <div class='d-flex'>
                            <input type='text' class='form-control mx-1' placeholder='Search...' id='search-part-title'>
                            <select class='movie-part' class='form-control w-50 mx-1'>
                                <option value='0'>Any</option>";
                                for($i=1;$i<=50;$i++){
                                    $output.="<option value='{$i}'>Part {$i}</option>";
                                }
                            $output.="</select>
                            <select id='language' class='form-control w-50 mx-1'>
                            <option value='0'>All</option>
                            ";
                                $result = mysqli_query($connection,"SELECT language FROM language");
                                while($row = mysqli_fetch_assoc($result))
                                {
                                    $output.="<option value='{$row['language']}'>{$row['language']}</option>";
                                }
                            $output.="</select>
                        </div>
                        <button class='btn btn-primary mx-auto my-2' id='search-parts' data-type='movie'>Search</button>
                    </div>
                    <div class='searched-parts'>
                        <span>Searched results for part <span id='part-number'></span></span>
                        <div class='all-movies-holder'>
                            
                        </div>
                    </div>
                </div>
            </div>

<form action='' class='form-wrapper'>
<div class='main-content'>
    <div class='main-content-left form-group'>
    <label class='badge badge-dark'>Movie title:</label>
        <div class='d-flex'>
            <input type='text' id='movie-title' class='form-control' placeholder='Enter Movie Title' required>
            <select class='movie-part' data-type='movie'>
            ";
            for($i=1;$i<=50;$i++){
                $output.="<option value='{$i}'>Part {$i}</option>";
            }

        $output.="
        </select>
        </div>
        <br>
        <label class='badge badge-dark'>Add description:</label>
        <textarea type='text' id='movie-description' class='form-control' placeholder='Add description'></textarea>
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
        <div class='input-selected-tags selected-categories'></div>
        <br>
        <label class='badge badge-dark'>Age:</label>
        <input type='number' id='movie-age' class='form-control' placeholder='Enter age'>
        <br>
        <label class='badge badge-dark'>Movie status:</label>
            <select id='movie-status' class='form-control'>
                <option value='paid' selected>Paid</option>
                <option value='free'>Free</option>
            </select>
    </div>
    <div class='main-content-right form-group'>
    <label class='badge badge-dark'>Thumbnail</label>
        <input type='text' id='movie-thumbnail' class='form-control' placeholder='Add Thumbnail'>
        <br>
        <div class='link-add-wrapper'>
        <div class='d-flex justify-content-around my-2'><span class='current-link' id='video-link'>Video link</span><span id='video-iframe'>Iframe</span></div>
            <input type='text' id='movie-link' class='form-control movie-link-input vedio-link-tab' placeholder='Enter link'>
            <textarea type='text' id='movie-iframe' class='form-control d-none movie-link-input vedio-iframe-tab' placeholder='Enter Embeded code'></textarea>
        </div>
        <br>
        <label class='badge badge-dark'>Released Year:</label>
        <input type='number' id='movie-year' class='form-control' placeholder='Released year'>
        <br>
        <label class='badge badge-dark'>Duration:</label>
        <input type='number' id='movie-duration' class='form-control' placeholder='Enter duration in minutes'>
        <br>
        <label class='badge badge-dark'>Language:</label>
            <select id='movie-language' class='form-control'>";
            $result = mysqli_query($connection,"SELECT language FROM language");
            while($row = mysqli_fetch_assoc($result))
            {
                $output.="<option value='{$row['language']}'>{$row['language']}</option>";
            }
            $output.="</select>
    </div>
</div>
<button class='btn btn-primary add-to-db' value='0' id='publish-movie'>Publish</button>
</form>";

echo $output;