<?php
	session_start();
if ((!isset($_SESSION['zalogowany']))||($_SESSION['status']<'2')||($_SESSION['ban']==false))
	{
		header('Location: index.php');
		exit();
	}
require_once "connection.php";
try 
		{ 
            if (isset($_POST['id_pos']))
            {
                $idposta=$_POST['id_pos'];
                $_SESSION['id_posta']=$_POST['id_pos'];

            }else{
                $idposta=$_SESSION['id_posta'];

            }
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if (isset($_POST['title']))
	{	
            $wszystko_OK=true;
		// Sprawdź poprawność adresu email
		$title = $_POST['title'];
		 
          if ($wszystko_OK==true)
                    {					
				                    
                    if ($polaczenie->query("UPDATE `posts` SET `title` = '$title' WHERE `posts`.`id_pos` ='$idposta';"))//wprowadzanie nowego urzytkownika
					{
						header('Location:texartikul_edit.scr.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
				}
				
				$polaczenie->close();
			} 
              if (isset($_POST['article']))
	{	
            $wszystko_OK=true;
		// Sprawdź poprawność adresu email
		$article = $_POST['article'];
		 
          if ($wszystko_OK==true)
                    {					
				                    
                    if ($polaczenie->query("UPDATE `posts` SET `article` = '$article' WHERE `posts`.`id_pos` ='$idposta';"))//wprowadzanie nowego urzytkownika
					{
						header('Location:texartikul_edit.scr.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
				}
				
				$polaczenie->close();
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
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
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
                    <li class="nav-item"> <a class="nav-link" href="artykulzak.php">wyświetl artykuły do akceptacji</a></li>
	
					<?php }
                    ?>
                    
                    <li class="nav-item"><a class="nav-link" href="wyswietlmojedane.php">wyświetl swój profil</a></li>
                                    <li class="nav-item"><a class="nav-link" href="dzial_zak_moja.php">wyświetl moją aktywność</a></li>
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
<?php 
                $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                $rezultat = $polaczenie->query("SELECT * FROM posts WHERE id_pos='$idposta'"); 
                $rezultaty=mysqli_fetch_assoc($rezultat);
                ?>
  <div class=" tylna_tablica container">
       
         <div class="row">
        <div class="panel panel-dark rej col-md-11 col-lg-11 offset-md-1 tylna_tablica">
             <div class="row">
            <div class="panel-heading tekstintableuser col-lg-6">Zmien tytuł posta :</div>
            <div class="panel-body col-lg-6">
            <form method="post">
               <div class="row"> 
		 <input class="col-lg-6" type="text" value="<?php
			echo $rezultaty['title'];
		?>" name="title" placeholder="title" onfocus="this.placeholder=''" onblur="this.placeholder='title'"/><br />
              <input class="zielony_przycisk col-lg-6"  type="submit" value="zmień" />
                </div>
                </form>
            </div></div>  
             </div> 
             <div class="panel panel-dark rej col-md-11 col-lg-11 offset-md-1 tylna_tablica">
            <div class="panel-heading tekstintableuser col-lg-12">Zmien tresc posta :</div>
            <div class="panel-body">
            <form method="post">
                        <textarea class="form-control" rows="26" name="article" placeholder="article" onfocus="this.placeholder=''" onblur="this.placeholder='article'"><?php
                        echo $rezultaty['article'];
                    ?></textarea>
              <input class="zielony_przycisk\"  type="submit" value="zmień" />

                </form>
  
             </div> 
             </div>
             
      </div>
    </div>
     <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
    </body>
	
</html>    