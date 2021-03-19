<?php
include "includes/db.php";

class Category
{
    function get_all_category(){
        global $connection;
        $output = '';
        $result = mysqli_query($connection,"SELECT * FROM category");
        while($row = mysqli_fetch_assoc($result))
        {
            $output.= "<li class='list-item w-50 text-capitalize py-2'>".$row['category']."</li>";
        }
        echo $output;
    }
}
