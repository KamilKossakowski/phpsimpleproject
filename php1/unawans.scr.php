<?php
include("connection.php");
$obj = mysqli_connect($host, $db_user, $db_password, $db_name);
$uid = mysqli_real_escape_string($obj, $_POST["username"]);

if(isset($_POST['username']))
{   
    $obj->query("UPDATE `uzytkownicy` SET `status`='0' WHERE username='$uid'");
    header("Location: userlist.php");
} 
else
{
    header("Location: ../");
}?>