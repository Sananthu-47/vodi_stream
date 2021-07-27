<?php
include_once "../includes/db.php";
include_once "../../Classes/Webseries.php";
$Webseries = new Webseries($connection);
$webseries = $Webseries->get_all_webseries_seasons_by_seriesid_admin($episode_id);
$webseries_data = mysqli_fetch_assoc($webseries);

$output = '';

$output.="<form action='' class='form-wrapper' id='update-episode-form'>
<div class='main-content'>
    <div class='main-content-left form-group'>
    <label class='badge badge-dark'>Episode title:</label>
        <div class='d-flex'>
            <input type='text' id='episode-title' class='form-control' placeholder='Enter Episode Title' value='{$webseries_data['title']}' required>
            <select id='episode-part' data-type='episode'>
            ";
            for($i=1;$i<=250;$i++){
                $output.="<option value='{$i}'";
                if($i == $webseries_data['episode_number'])
                {
                    $output.='selected';
                }
                $output.=">Episode {$i}</option>";
            }

        $output.="
        </select>
        </div>
        <br>
        <label class='badge badge-dark'>Add description:</label>
        <textarea type='text' id='episode-description' required class='form-control' placeholder='Add description'>{$webseries_data['description']}</textarea>
        <br>
        <label class='badge badge-dark'>Episode status:</label>
            <select id='episode-status' class='form-control'>
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
        <br>
        <label class='badge badge-dark'>Thumbnail</label>
        <input type='text' id='episode-thumbnail' class='form-control' required value='{$webseries_data['thumbnail']}' placeholder='Add Thumbnail'>
    </div>
    <div class='main-content-right form-group'>
        <div class='link-add-wrapper'>
        <div class='d-flex justify-content-around my-2'><span class='current-link' id='video-link'>Video link</span><span id='video-iframe'>Iframe</span></div>
            <input type='text' id='episode-link' value='{$webseries_data['link']}' class='form-control movie-link-input vedio-link-tab' placeholder='Enter link'>
            <textarea type='text' id='episode-iframe' class='form-control d-none movie-link-input vedio-iframe-tab' placeholder='Enter Embeded code'>{$webseries_data['iframe']}</textarea>
        </div>
        <br>
        <label class='badge badge-dark'>Released Year:</label>
        <input type='number' id='episode-year' value='{$webseries_data['release_year']}' required class='form-control' placeholder='Released year'>
        <br>
        <label class='badge badge-dark'>Duration:</label>
        <input type='number' id='episode-duration' value='{$webseries_data['duration']}' required class='form-control' placeholder='Enter duration in minutes'>
    </div>
</div>
<button class='btn btn-primary add-to-db' data-id='$episode_id' id='update-episode'>Update</button>
</form>";

echo $output;