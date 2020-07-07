<?php
session_start();
include("connection.php");
$obj = mysqli_connect($host, $db_user, $db_password, $db_name);
if (isset($_POST['useridpos']))
	{
		$iduser=$_POST['useridpos'];
        $_SESSION['useridpos']=$_POST['useridpos'];
    
	}else{
		$iduser=$_SESSION['useridpos'];
    
	}

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Java -programujmy</title>
    <meta name="description" content="Serwis zrzeszający programistów języka Java" />
	<meta name="keywords" content="java, komputerowe, programiści, kod, dyskusja, programy" />
      <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body class="tyl">
    		<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
		
			<a class="navbar-brand" href="#"><img src="obrazki/logo.png" width="30" height="30" class="d-inline-block mr-1 align-bottom" alt=""> Java</a>
		
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
				<span class="navbar-toggler-icon"></span>
			</button>
		
			<div class=" collapse navbar-collapse" id="mainmenu">
			<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="stronapierwsza.php"> Start </a>
					</li>
             <?php   if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{                  ?>
                    <li><p class="nav-item"><a class="nav-link" href="wyswietlmojedane.php">Witaj <?php echo $_SESSION['user'];?></a></li>
                    <li class="nav-item"><a class="nav-link" href="artykul.php">wyświetl artykuły</a></li>
                    <?php if($_SESSION['status']>'1'){
                    ?>
                    <li class="nav-item"> <a class="nav-link" href="userlist.php">wyświetl uzytkowników</a></li>	
					<?php }
                    ?>
                    
                    <li class="nav-item"><a class="nav-link" href="wyswietlmojedane.php">wyświetl swój profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Wyloguj się</a></li>
<?php				}else{ ?>
                    <li class="nav-item"><a class="nav-link" href="artykul.php">wyświetl artykuły</a></li>
                    <li class="nav-item"> <a class="nav-link" href="zaloguj.php">Zaloguj się</a></li>
					<li class="nav-item"><a class="nav-link" href="rejestracja.php">Rejestracja</a></li>
				   <?php } ?>
				</ul>	
			</div>
		</nav>
 
<div class="cowgurze">internet exploer to całkowite zero</div>
       <?php if(isset($_SESSION['ban'])){if($_SESSION['ban']==false){ ?><h2 class="error"> You are banned</h2><?php }} ?>
    <div class="container d-md-inline d-sd-inline">
         <div class="row">
<?php 
                $rezultat = $polaczenie->query("SELECT `profile_images`.`file_name`,`profile_images`.`slowkilka`,`profile_images`.`krajpoch`,`profile_images`.`wyksz`,`profile_images`.`zain`,uzytkownicy.username,uzytkownicy.email,uzytkownicy.dolaczyl,uzytkownicy.status FROM `uzytkownicy`,`profile_images` WHERE `uzytkownicy`.`id`='$iduser'and `uzytkownicy`.`id` = `profile_images`.`id`"); 
                $rezultaty=mysqli_fetch_assoc($rezultat);
?>    
     <div class=" tylna_tablica container">
        <div class="rej col-md-11 col-lg-11  offset-md-1">
        <div class="panel-heading tekstintableuser">nazwa urzytkownika</div>
            <div class="panel-body napisynaczarnym">
             <?php echo  $rezultaty['username']?>
            </div></div>
     <div class=" tylna_tablica container">
        <div class="rej col-md-11 col-lg-11  offset-md-1">
        <div class="panel-heading tekstintableuser">Email</div>
            <div class="panel-body napisynaczarnym">
             <?php echo  $rezultaty['email']?>
            </div></div>          
         <div class="panel panel-dark rej col-md-11 col-lg-11 offset-md-1 tylna_tablica">
            <div class="panel-heading tekstintableuser">aktualna fotografia urzytkownika</div>
            <div class="panel-body">
                 <img class="obrazekurzyt " src="obrazkiurzytkownikow/<?php echo $rezultaty['file_name']?>" alt="twatwrzyczka" >
             </div></div>
             <div class="panel panel-dark rej col-md-11 col-lg-11  offset-md-1 tylna_tablica">
            <div class="panel-heading tekstintableuser">Coś o mnie</div>
            <div class="panel-body napisynaczarnym">
                  <?php
                        echo $rezultaty['slowkilka'];
                    ?>
              
             </div></div>
             <div class="panel panel-dark rej col-md-11 col-lg-11 offset-md-1 tylna_tablica">
            <div class="panel-heading tekstintableuser">Skąd jest</div>
            <div class="panel-body napisynaczarnym">
<?php
                        echo $rezultaty['krajpoch'];

?>
             </div></div>
             <div class="panel panel-dark rej col-md-11 col-lg-11  offset-md-1 tylna_tablica">
            <div class="panel-heading tekstintableuser">wykształcenie</div>
            <div class="panel-body napisynaczarnym">
                 <?php
                        echo $rezultaty['wyksz'];
                    ?>
             </div></div>
             <div class="panel panel-dark rej col-md-11 col-lg-11  offset-md-1 tylna_tablica">
            <div class="panel-heading tekstintableuser">jakie masz zainteresowania?</div>
            <div class="panel-body napisynaczarnym">
                 <?php
                        echo $rezultaty['zain'];
                         ?>
             </div></div>
         </div>
    </div>   

        
        
        </div></div>
         <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
    </body>
	
</html>