<?php
include("connection.php");
$obj = mysqli_connect($host, $db_user, $db_password, $db_name);
$uid = mysqli_real_escape_string($obj, $_POST["useridpos"]);

if(isset($_POST['useridpos']))
{   

    $obj->query("DELETE FROM `posts` WHERE `id_pos` = '$uid'");
    $obj->query("DELETE FROM `komentarze` WHERE `id_post` = '$uid'");
    header("Location: artukul.php");
} 
else
{
    header("Location: ../");
}?>