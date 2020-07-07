<?php
session_start();
 if(isset($_FILES['image'])){
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
      
      $expensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 2097152){
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"obrazkiurzytkownikow/".$file_name);
            include("connection.php");
            $obj = mysqli_connect($host, $db_user, $db_password, $db_name);
            $uid = mysqli_real_escape_string($obj,$_SESSION['user']);
          $id_smier=$obj->query("SELECT id FROM `uzytkownicy` WHERE `uzytkownicy`.`username` ='$uid'");
          $id_smierci=mysqli_fetch_assoc($id_smier);
          $id_smi=$id_smierci['id'];
          $obj->query("UPDATE `profile_images` SET `file_name` = '$file_name' WHERE `profile_images`.`id`='$id_smi'");
        header("Location: wyswietlmojedane.php");
      }else{
         print_r($errors);
      }
   }
?>
