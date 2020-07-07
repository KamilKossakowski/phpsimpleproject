<?php
include("connection.php");
$obj = mysqli_connect($host, $db_user, $db_password, $db_name);
$uid = mysqli_real_escape_string($obj, $_POST["useridpos"]);

if(isset($_POST['useridpos']))
{   

    $obj->query("UPDATE `komentarze` SET `status` = '2' WHERE `komentarze`.`id_kom`='$uid'");
    
    header("Location: artykulzak.php");
} 
else
{
    header("Location: ../");
}?>