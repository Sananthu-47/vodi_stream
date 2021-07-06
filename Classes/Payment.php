<?php

class Payment
{
    public $connection;

    function __construct($connection)
    {
        $this->connection = $connection;
    }

    function getAllPackage(){
        $result = mysqli_query($this->connection,"SELECT * FROM package");
        return $result;
    }

    function getPackageById($get_value,$id){
        $result = mysqli_query($this->connection,"SELECT $get_value FROM package WHERE id = '$id'");
        $row = mysqli_fetch_array($result);
        return $row[0];
    }

    function getAllPaymentById($id){
        $result = mysqli_query($this->connection,"SELECT * FROM payments WHERE id = '$id'");
        return $result;
    }

    function getPaymentById($get_value,$id){
        $result = mysqli_query($this->connection,"SELECT $get_value FROM payments WHERE id = '$id'");
        $row = mysqli_fetch_array($result);
        return $row[0];
    }
}
