<?php

class Category
{
    public $connection;

    function __construct($connection)
    {
        $this->connection = $connection;
    }

    function get_all_category(){
        $output = '';
        $result = mysqli_query($this->connection,"SELECT * FROM category");
        while($row = mysqli_fetch_assoc($result))
        {
            $output.= "<li class='list-item w-50 text-capitalize py-1'>".$row['category']."</li>";
        }
        echo $output;
    }

    function get_all_category_admin(){
        $result = mysqli_query($this->connection,"SELECT * FROM category");
        return $result;
    }

    function get_category_by_id($category_id){
        $result = mysqli_query($this->connection,"SELECT category FROM category WHERE id = '$category_id'");
        return $result;
    }

    function check_category_exists($category_name){
        $result = mysqli_query($this->connection,"SELECT * FROM category WHERE category = '$category_name'");
        return $result;
    }
}
