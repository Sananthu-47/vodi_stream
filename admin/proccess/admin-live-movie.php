<?php
include_once "../includes/db.php";
include "../../Classes/Movie.php";
include "../../Classes/Category.php";
$Movie = new Movie($connection);
$Category = new Category($connection);
$output = '';
$count = 1;
$result = $Movie->get_all_movies();

$output.="<div class='content-table-wrapper'>
<table class='table'>
    <thead class='thead-dark'>
    <tr class='text-center'>
        <th>Id</th>
        <th>Title</th>
        <th>Category</th>
        <th>Part / Episode</th>
        <th>Status</th>
        <th>Age</th>
        <th>Duration</th>
        <th>Language</th>
        <th>Released</th>
        <th>Action</th>
    </tr>";

                while($row = mysqli_fetch_assoc($result))
                    {
                        $output.="
                        <tr class='text-center'>
                        <td>{$count}</td>
                        <td>{$row['title']}</td>
                        <td>
                        ";
                        $all_categories = explode(',',$row['category']);
                        foreach ($all_categories as $key => $category) {
                            $output.="<span class='badge badge-info mx-1'>{$category}</span>";
                        }
                        $output.="</td>
                        <td>{$row['part']}</td>
                        <td>{$row['status']}</td>
                        <td>{$row['age']}+</td>
                        <td>{$row['duration']} minutes</td>
                        <td>{$row['language']}</td>
                        <td>{$row['release_year']}</td>
                        <td class='d-flex justify-content-around'>
                            <button class='btn btn-info ml-2 make-movie-delete' data-id='{$row['id']}'><i class='fa fa-trash text-white'></i></button>
                            <a href='admin-update.php?movie-id={$row['id']}'><button class='btn btn-primary mx-2'><i class='fa fa-pencil-square-o text-white'></i></button></a>
                            <button class='btn btn-success make-movie-active'";
                            if($row['watchable'] == 'active') $output.='disabled';
                            $output.=" data-id='{$row['id']}'><i class='fa fa-check text-white'></i></button>
                            <button class='btn btn-danger mx-2 make-movie-blocked'";
                            if($row['watchable'] == 'blocked') $output.='disabled';
                            $output.=" data-id='{$row['id']}'><i class='fa fa-ban text-white'></i></button>
                        </td>
                        </tr>";
                        $count++;
                    }

    $output.="</thead>
</table>
</div>";

echo $output;