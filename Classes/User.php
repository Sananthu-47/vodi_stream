<?php
include "../includes/db.php";
class User{
    //Check whether user already exists in db or not
    function check_user_exists($email,$mobile_number){
        global $connection;
        $result = mysqli_query($connection,"SELECT * FROM users WHERE email = '$email' OR mobile_number = '$mobile_number'");
        if(mysqli_num_rows($result)>0)
        {
            return true;
        }else{
            return false;
        }
    }
    //Add new user to the db
    function add_user($email,$mobile_number,$password){
        global $connection;
        $result = mysqli_query($connection,"INSERT INTO users (email,mobile_number,password,version,payed,status) VALUES ('$email','$mobile_number','$password','free',0,'user')");
        if($result)
        {
            return true;
        }
            return false;
    }

    function valid_email($str) {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
        }
}