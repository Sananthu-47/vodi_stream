<?php

class Category
{
    public $connection;

    function __construct($connection)
    {
        $this->connection = $connection;
    }

    function get_all_category(){
        // global $connection;
        $output = '';
        $result = mysqli_query($this->connection,"SELECT * FROM category");
        while($row = mysqli_fetch_assoc($result))
        {
            $output.= "<li class='list-item w-50 text-capitalize py-2'>".$row['category']."</li>";
        }
        echo $output;
    }

    function get_all_category_admin(){
        $result = mysqli_query($this->connection,"SELECT * FROM category");
        return $result;
    }

    function get_category_on_type($data){
        $result = mysqli_query($this->connection,"SELECT * FROM category WHERE category LIKE '$data%' LIMIT 1");
        return mysqli_fetch_assoc($result);
    }

    function add_selected_categories($categories,$movie_id){
        foreach ($categories as $key => $value) {
            mysqli_query($this->connection,"INSERT INTO category_selected (category_id,movie_series_id) VALUES ('$value','$movie_id')");
        }
        return true;
    }

    function selected_categories($movie_id){
        $result = mysqli_query($this->connection,"SELECT category_id FROM category_selected WHERE movie_series_id = '$movie_id'");
        return $result;
    }

    function get_category_by_id($category_id){
        $result = mysqli_query($this->connection,"SELECT category FROM category WHERE id = '$category_id'");
        return $result;
    }
}
