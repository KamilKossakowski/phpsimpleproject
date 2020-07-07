<?php

	session_start();
require_once "connection.php";
try 
		{ 
    $id_us=$_SESSION['id'];
                        
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if (isset($_POST['title']))
	       {	
            $wszystko_OK=true;
		// Sprawdź poprawność adresu email
		$title = $_POST['title'];
		 
			} 
              if (isset($_POST['article']))
	       {	
            $wszystko_OK=true;
		// Sprawdź poprawność adresu email
		$article = $_POST['article'];
		 
			} 
                if ((isset($_POST['title']))&&(isset($_POST['article'])))
                {
                   if ($polaczenie->query("INSERT INTO posts VALUES (NULL, '$id_us','$title', '$article',NOW(),NOW(),1)"))
                   {
                      header("Location: artykul.php"); 
                   } 
                }
            }
        catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;
		}

?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    
	<meta charset="utf-8" />
	<title>Java -programujmy</title>
    <meta name="description" content="Serwis zrzeszający programistów języka Java" />
	<meta name="keywords" content="java, komputerowe, programiści, kod, dyskusja, programy" />
    <link rel="stylesheet" href="css/bootstrap.css">
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body class="tyl">
<nav class="navbar navbar-dark bg-dark navbar-expand-lg fixed-top">
		
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
                    <li class="nav-item"> <a class="nav-link" href="texartikul_new.scr.php">utwórz nowy artykuł</a></li>
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
  <div class=" tylna_tablica container">
       
         <div class="row">
        <div class="panel panel-dark rej col-md-11 col-lg-12 offset-md-1 tylna_tablica">
            <div class="panel-heading tekstintableuser">Podaj tytuł</div>
            <div class="panel-body">
            <form method="post"> 
		          <input type="text" value="<?php
                                            if(isset($title)){ echo $title;}
                                            ?>" name="title" placeholder="title" onfocus="this.placeholder=''" onblur="this.placeholder='title'"/><br />
                <textarea class="form-control" rows="26" name="article" placeholder="article" onfocus="this.placeholder=''" onblur="this.placeholder='article'">
                    <?php
                                            if(isset($article)){ echo $article;}
                                            ?></textarea>
              <input class="zielony_przycisk" type="submit" value="Utwórz" />
            
                </form>
            </div></div>
      </div>
    </div>
     <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
    </body>
	
</html>    