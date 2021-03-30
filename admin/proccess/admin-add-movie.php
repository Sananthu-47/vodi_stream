<?php

echo "<form action='' class='form-wrapper'>
<div class='main-content'>
    <div class='main-content-left form-group'>
        <input type='text' class='form-control' placeholder='Enter Movie Title'>
        <br>
        <textarea type='text' class='form-control' placeholder='Add description'></textarea>
        <br>
        <input type='text' class='form-control' placeholder='Select a Category'>
        <br>
        <input type='text' class='form-control' placeholder='Enter Movie Title'>
        <br>
            <select id='inputState' class='form-control' placeholder='Select part number'>
                <option selected>Select video status</option>
                <option>Paid</option>
                <option>Free</option>
            </select>
    </div>
    <div class='main-content-right form-group'>
        <input type='text' class='form-control' placeholder='Add Thumbnail'>
        <br>
        <input type='text' class='form-control' placeholder='Add Casting'>
        <br>
        <input type='text' class='form-control' placeholder='Enter link or Embeded Code'>
    </div>
</div>
<button class='btn btn-primary'>Publish</button>
</form>";