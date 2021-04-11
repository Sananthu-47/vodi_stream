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
                                    $output.="<option value='{$i}'>Season {$i}</option>";
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
                        <button class='btn btn-primary mx-auto my-2' id='search-parts' data-type='webseries'>Search</button>
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
    <label class='badge badge-dark'>Webseries title:</label>
        <div class='d-flex'>
            <input type='text' id='webseries-title' class='form-control' placeholder='Enter Webseries Title' required>
            <select class='movie-part' data-type='webseries'>";
            for($i=1;$i<=25;$i++){
                $output.="<option value='{$i}'>Season {$i}</option>";
            }
            $output.="</select>
        </div>
        <br>
    <label class='badge badge-dark'>Webseries description:</label>
        <textarea type='text' id='webseries-description' class='form-control' placeholder='Add description'></textarea>
        <br>
    <label class='badge badge-dark'>Select Category:</label>
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
        <input type='number' id='webseries-age' class='form-control' placeholder='Enter age'>
        <br>
    <label class='badge badge-dark'>Webseries Status:</label>
            <select id='webseries-status' class='form-control'>
                <option value='paid' selected>Paid</option>
                <option value='free'>Free</option>
            </select>
            <br>
    <label class='badge badge-dark'>Webseries Thumbnail:</label>
            <input type='text' id='webseries-thumbnail' class='form-control' placeholder='Add Thumbnail'>
            <br>
    <label class='badge badge-dark'>Release Year:</label>
            <input type='number' id='webseries-year' class='form-control' placeholder='Released year'>
        <br>
    <label class='badge badge-dark'>Language:</label>
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
                <input type='text' id='webseries-link' class='form-control movie-link-input vedio-link-tab mb-3' placeholder='Enter link'>
                <textarea type='text' id='webseries-iframe' class='form-control movie-link-input vedio-iframe-tab mb-3 d-none' placeholder='Enter Embeded code'></textarea>
    <label class='badge badge-dark'>Episode title:</label>
                <input type='text' id='episode-title' class='form-control mb-3' placeholder='Enter title'>
    <label class='badge badge-dark'>Select Episode:</label>
                <select id='webseries-episode' class='form-control mb-3'>
                    <option value='0'>Select episode</option>";
                    for($i=1;$i<=200;$i++){
                        $output.="<option value='{$i}'>Episode {$i}</option>";
                    }
                    $output.="
                </select>
    <label class='badge badge-dark'>Episode description:</label>
                <textarea type='text' id='episode-description' class='form-control mb-3' placeholder='Enter the episode description'></textarea>
    <label class='badge badge-dark'>Episode Thumbnail:</label>
                <input type='text' id='episode-thumbnail' class='form-control mb-3' placeholder='Add Thumbnail'>
    <label class='badge badge-dark'>Release Year:</label>
                <input type='number' id='episode-year' class='form-control mb-3' placeholder='Year of release'>
    <label class='badge badge-dark'>Episode Duration:</label>
                <input type='number' id='episode-duration' class='form-control mb-3' placeholder='Add duration in minutes'>
                <div class='btn btn-success my-1 mx-auto px-5' id='add-episode'>Add</div>
            </div>
        </div><!--link-add-wrapper-->

        <div class='input-selected-tags added-episodes'></div>
        <br>

    </div>
</div>
<button class='btn btn-primary add-to-db' value='0' id='publish-webseries'>Publish</button>
</form>";

// $output.="<script type='text/javascript' src='../assets/js/add-webseries.js' async></script>";

echo $output;

