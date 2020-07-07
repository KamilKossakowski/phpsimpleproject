<?php
include("connection.php");
$obj = mysqli_connect($host, $db_user, $db_password, $db_name);
$uid = mysqli_real_escape_string($obj, $_POST["username"]);

if(isset($_POST['username']))
{   
    $id_smier=$obj->query("SELECT id FROM `uzytkownicy` WHERE `uzytkownicy`.`username` ='$uid'");
    $id_smierci=mysqli_fetch_assoc($id_smier);
    $id_smi=$id_smierci['id'];
    $obj->query("DELETE FROM `uzytkownicy` WHERE `uzytkownicy`.`username` = '$uid'");
    $obj->query("DELETE FROM `profile_images` WHERE `profile_images`.`id` = '$id_smi'");
    $obj->query("UPDATE `komentarze` SET `id_user` = '0' WHERE `komentarze`.`id_user` ='$id_smi'");
    $obj->query("UPDATE `posts` SET `user_id_pos` = '0' WHERE `posts`.`user_id_pos` ='$id_smi'");
    header("Location: userlist.php");
} 
else
{
    header("Location: ../");
}?>