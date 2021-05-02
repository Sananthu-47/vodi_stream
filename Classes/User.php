<?php
// include "../includes/db.php";
class User{

    public $connection;

    function __construct($connection)
    {
        $this->connection = $connection;
    }

    // Get data of all users
    function get_all_users()
    {
        $result = mysqli_query($this->connection,"SELECT * FROM users WHERE status != 'deleted' ORDER BY role");
        return $result;
    }

    //Check whether user already exists in db or not
    function check_user_exists($email,$mobile_number){
        // global $connection;
        $result = mysqli_query($this->connection,"SELECT * FROM users WHERE email = '$email' OR mobile_number = '$mobile_number'");
        if(mysqli_num_rows($result)>0)
        {
            return true;
        }else{
            return false;
        }
    }
    //Add new user to the db
    function add_user($username,$email,$mobile_number,$password,$role){
        // global $connection;
        $result = mysqli_query($this->connection,"INSERT INTO users (username,email,mobile_number,password,pricing,payed,role) VALUES ('$username','$email','$mobile_number','$password','free',0,'$role')");
        if($result)
        {
            return true;
        }
            return false;
    }

    function valid_email($str) {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
        }

    function login_user($email_number,$password,$type)
    {
        // global $connection;
        $query = "SELECT * FROM users WHERE ";
        if($type == 'email')
        {
            $query.="email = '$email_number' AND password = '$password'";
        }else{
            $query.="mobile_number = '$email_number' AND password = '$password'";
        }
        
        $result = mysqli_query($this->connection,$query);
        if(mysqli_num_rows($result)>0)
        {
            return mysqli_fetch_assoc($result);
        }else{
            return false;
        }
    }

    // Check the user is using free version or not
    function check_account_is_premium($id){
        if(!$id == '')
        {
            $result = mysqli_query($this->connection,"SELECT pricing FROM users WHERE id = '$id'");
            $row = mysqli_fetch_assoc($result);
            if($row['pricing'] == 'free')
            {
                return true;
            }else{
                return false;
            }
        }
        return true;
    }

    // Check the user is admin or not
    function check_admin_or_not($id){
        if(!$id == '')
        {
            $result = mysqli_query($this->connection,"SELECT role FROM users WHERE id = '$id'");
            $row = mysqli_fetch_assoc($result);
            if($row['role'] == 'admin')
            {
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    // Get a particular data
    function get_user_detail_by_id($get_value,$id)
    {
        $result = mysqli_query($this->connection,"SELECT $get_value FROM users WHERE id = '$id'");
        $row = mysqli_fetch_array($result);
        return $row[0];
    }
}
