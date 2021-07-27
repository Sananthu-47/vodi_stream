<?php
session_start();
include "../includes/db.php";
include_once "../Classes/Webseries.php";
$Webseries = new Webseries($connection);
$id = $_POST['id'];
$type = $_POST['type'];

if($type == 'webseries_name')
{
   $title = $Webseries->get_webseries_by_id_and_search('title',$id);
   echo $title;
}