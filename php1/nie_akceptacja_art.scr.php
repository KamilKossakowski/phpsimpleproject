<?php

include("connection.php");
$obj = mysqli_connect($host, $db_user, $db_password, $db_name);

if(isset($_POST['id_pos']))
{
    $abc=$_POST['id_pos'];
    $obj->query("UPDATE `posts` SET `akceptacja` = '2' WHERE `posts`.`id_pos` =$abc");
    header("Location: artykulzak.php");
} 
else
{
    header("Location: ../");
}?>