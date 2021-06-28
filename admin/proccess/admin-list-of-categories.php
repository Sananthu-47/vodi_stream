<?php
include_once "../includes/db.php";
include_once "../../Classes/Category.php";
$Category = new Category($connection);
$categories = $Category->get_all_category_admin();
$output = '';
$output .= "
<div class='d-flex align-items-center mr-2 p-0 col-sm-12 col-lg-6'><label class='h5 mx-2'>Add new category: </label> <input id='category-name' type='text' class='form-control' placeholder='Enter new category'/> <button id='add-category' class='btn btn-success mx-2'>Add</button>
<div id='update-category-div' style='display:none'>
    <button id='update-category' class='btn btn-warning mx-2'>Update</button>
    <button id='cancel'>Cancel</button>
</div>
</div>
<div class='content-table-wrapper'>
    <table class='table'>
        <thead class='thead-dark'>
            <tr>
                <th>Id</th>
                <th>Category</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>";
        $count = 0;
        while($row = mysqli_fetch_assoc($categories)){
            $count++;
            $output.="
                <tr>
                    <td>{$count}</td>
                    <td class='text-capitalize'>{$row['category']}</td>
                    <td><button class='btn btn-primary mx-2 edit' data-category='{$row['category']}' data-id='{$row['id']}'><i class='fa fa-pencil-square-o text-white'></i></button></td>
                    <td><button class='btn btn-danger ml-2 make-category-delete' data-id='{$row['id']}'><i class='fa fa-trash text-white'></i></button></td>
                </tr>
            ";
        }
        $output.="</tbody>
    </table>
</div>";
echo $output;
?>