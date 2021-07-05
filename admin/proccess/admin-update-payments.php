<?php
include_once "../includes/db.php";
include_once "../../Classes/Payment.php";
$Payment = new Payment($connection);

$output = '';
$output.="<form action='' class='form-wrapper'>
<div class='main-content'>
    <div class='main-content-left form-group'>";
    $package = $Payment->getAllPackage();
    while($row = mysqli_fetch_assoc($package)){
        $output.="
        <label for='' class='text-capitalize'>{$row['package']}</label>
        <input type='number' class='form-control' id='{$row['package']}' value='{$row['price']}' min='0' placeholder='Enter payment price'>
        <br>
        ";
    }
    $output.="<button class='btn btn-primary' id='update-payment'>Update</button>
    </div>
</div>
</form>";
echo $output;