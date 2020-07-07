<?php
include("connection.php");
$obj = mysqli_connect($host, $db_user, $db_password, $db_name);
$uid = mysqli_real_escape_string($obj, $_POST["username"]);

if(isset($_POST['username']))
{   
    $obj->query("UPDATE `uzytkownicy` SET `status`='1' WHERE username='$uid'");
    $_SESSION['status'] = 1;
    header("Location: wyswietlmojedane.php");
} 
else
{
    header("Location: ../");
}?>
