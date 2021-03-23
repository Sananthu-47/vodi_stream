<?php
include_once "../includes/db.php";
include "../Classes/User.php";
$User = new User($connection);

$email = $_POST['email'];
$mobile_number = $_POST['mobile_number'];
$password = $_POST['password'];
$erorr_array = [];

if($email=='' || !$User->valid_email($email))
{
    array_push($erorr_array,0);
}
if($mobile_number=='') 
{
    array_push($erorr_array,1);
}
if($password=='')
{
    array_push($erorr_array,2);
}

if(count($erorr_array)>0)
{
    echo json_encode($erorr_array);
}else{
if($User->check_user_exists($email,$mobile_number))
{
    echo 3;
}else{
    $User->add_user($email,$mobile_number,$password);
    echo 4;
}
}