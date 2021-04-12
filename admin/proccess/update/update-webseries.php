<?php
include_once "../includes/db.php";
include_once "../../Classes/Webseries.php";
include_once "../../Classes/Category.php";
$Category = new Category($connection);
$categories = $Category->get_all_category_admin();
$Webseries = new Webseries($connection);
$webseries = $Webseries->get_webseries_by_id($webseries_id);
$webseries_data = mysqli_fetch_assoc($webseries);

$output = '';

$output.="<form action='' class='form-wrapper'>
<div class='main-content'>
    <div class='main-content-left form-group'>
    <label class='badge badge-dark'>Webseries title:</label>
        <div class='d-flex'>
            <input type='text' id='webseries-title' class='form-control' placeholder='Enter Movie Title' value='{$webseries_data['title']}' required>
            <select class='movie-part' data-type='movie'>
            ";
            for($i=1;$i<=50;$i++){
                $output.="<option value='{$i}'";
                if($i == $webseries_data['season_number'])
                {
                    $output.='selected';
                }
                $output.=">Season {$i}</option>";
            }

        $output.="
        </select>
        </div>
        <br>
        <label class='badge badge-dark'>Add description:</label>
        <textarea type='text' id='webseries-description' class='form-control' placeholder='Add description'>{$webseries_data['description']}</textarea>
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
            <div class='all-categories-name'>{$webseries_data['category']}</div>
        </div>
        <br>
        <label class='badge badge-dark'>Webseries status:</label>
            <select id='webseries-status' class='form-control'>
                <option value='paid'";
                if('paid' == $webseries_data['status'])
                {
                    $output.='selected';
                }
                $output.=">Paid</option>
                <option value='free'";
                if('free' == $webseries_data['status'])
                {
                    $output.='selected';
                }
                $output.=">Free</option>
            </select>
    </div>
    <div class='main-content-right form-group'>
    <label class='badge badge-dark'>Age:</label>
    <input type='number' id='webseries-age' class='form-control' value='{$webseries_data['age']}' placeholder='Enter age'>
    <br>
    <label class='badge badge-dark'>Thumbnail</label>
        <input type='text' id='webseries-thumbnail' class='form-control' value='{$webseries_data['thumbnail']}' placeholder='Add Thumbnail'>
        <br>
        <label class='badge badge-dark'>Released Year:</label>
        <input type='number' id='webseries-year' value='{$webseries_data['release_year']}' class='form-control' placeholder='Released year'>
        <br>
        <label class='badge badge-dark'>End Year:</label><label class='mx-2 text-danger'>(Optional)</label>
        <input type='number' id='webseries-end' value='{$webseries_data['end_year']}' class='form-control' placeholder='Released year'>
        <br>
        <label class='badge badge-dark'>Language:</label>
            <select id='webseries-language' class='form-control'>";
            $result = mysqli_query($connection,"SELECT language FROM language");
            while($row = mysqli_fetch_assoc($result))
            {
                $output.="<option value='{$row['language']}'";
                if($webseries_data['language'] == $row['language'])
                {
                    $output.="selected";
                }
                $output.=">{$row['language']}</option>";
            }
            $output.="</select>
    </div>
</div>
<button class='btn btn-primary add-to-db' data-id='$webseries_id' value='{$webseries_data['part_1_id']}' id='update-webseries'>Update</button>
</form>";

echo $output;