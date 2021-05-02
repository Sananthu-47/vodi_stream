<?php
include_once "../includes/db.php";
include "../../Classes/Category.php";
$Category = new Category($connection);
$categories = $Category->get_all_category_admin();

$output = '';


$output.= "
<div class='part-selection-wrapper-episode' style='display:flex'>
                <div class='part-selection'>
                    <div class='text-header'><span>Choose the season to add episodes</span></div>
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
                        <button class='btn btn-primary mx-auto my-2' id='search-parts' data-type='episode'>Search</button>
                    </div>
                    <div class='searched-parts'>
                        <span>Searched results for part <span id='part-number'></span></span>
                        <div class='all-movies-holder'>
                            
                        </div>
                    </div>
                </div>
            </div>
";


$output.="<form action='' class='form-wrapper'>
<div class='main-content'>
    

<div class='main-content-left form-group'>
    <label class='badge badge-dark'>Webseries title:</label>
        <div class='d-flex'>
            <input type='text' id='webseries-title' class='form-control' placeholder='Enter Webseries Title' disabled>
            <select class='webseries-episode-part' data-type='episode'>";
            for($i=1;$i<=25;$i++){
                $output.="<option class='episode-option' value='{$i}'>Season {$i}</option>";
            }
            $output.="</select>
        </div>
        <br>
    </div>


    <div class='main-content-right form-group'>
    <div class='link-add-wrapper my-2'>
        <div class='d-flex justify-content-around my-2'><span class='current-link' id='video-link'>Video link</span><span id='video-iframe'>Iframe</span></div>
        <input type='text' id='webseries-link' class='form-control movie-link-input vedio-link-tab mb-3' placeholder='Enter link'>
            <textarea type='text' id='webseries-iframe' class='form-control movie-link-input vedio-iframe-tab mb-3 d-none' placeholder='Enter Embeded code'></textarea>
    </div><!--link-add-wrapper-->
        <div class='responsive-flex'>
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
            <div class='btn btn-success my-1 mx-auto px-5' id='add-new-episode'>Add</div>
        </div>

    <div class='input-selected-tags added-episodes'></div>
    <br>

    </div>
</div>
<button class='btn btn-primary' id='publish-new-episodes'>Publish</button>
</form>";

echo $output;