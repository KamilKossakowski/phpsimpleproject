<?php

	session_start();
require_once "connection.php";
		
$istam=$_SESSION['id'];

try 
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}else{
    
            if (isset($_POST['nick']))
            {
                //Udana walidacja? Załóżmy, że tak!
                $wszystko_OK=true;

                //Sprawdź poprawność nickname'a
                $nick = $_POST['nick'];

                //Sprawdzenie długości nicka
                if ((strlen($nick)<2) || (strlen($nick)>20))
                {
                    $wszystko_OK=false;
                    $_SESSION['e_nick']="Nick musi posiadać od 2 do 20 znaków!";
                }

                if (ctype_alnum($nick)==false)
                {
                    $wszystko_OK=false;
                    $_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
                }
                $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE username='$nick'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_nickow = $rezultat->num_rows;
				if($ile_takich_nickow>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_nick']="Istnieje już gracz o takim nicku! Wybierz inny.";
				}
                if ($wszystko_OK==true)
                    {					
				                    
                    if ($polaczenie->query("UPDATE `uzytkownicy` SET `username` = '$nick' WHERE `uzytkownicy`.`id` = '$istam';"))//wprowadzanie nowego urzytkownika
					{
                       $_SESSION['user']=$nick;
						header('Location: wyswietlmojedane.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
				}
				
				$polaczenie->close();
			}
            
            
		if (isset($_POST['email']))
	{	$wszystko_OK=true;
		// Sprawdź poprawność adresu email
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);//transformacja napisanego e-maila na kodowany email
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))//jeśli wykonana poprawę w nazwie i długość się zmieniła
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";}
            $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}		
		
          if ($wszystko_OK==true)
                {					
				                    
                    if ($polaczenie->query("UPDATE `uzytkownicy` SET `email` = '$email' WHERE `uzytkownicy`.`id` = '$istam';"))//wprowadzanie nowego urzytkownika
					{
                        $_SESSION['email'] =$email;
						header('Location: wyswietlmojedane.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
				}
				
				$polaczenie->close();
			}  
        
    if ((isset($_POST['haslo1']))&&(isset($_POST['haslo2'])))
	{	
		//Sprawdź poprawność hasła
        $haslo0 = $_POST['haslo0'];
        $haslo_hash = password_hash($haslo0, PASSWORD_DEFAULT);
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
	if($haslo_hash==$polaczenie->query("select password from uzytkownicy where id='$istam'")){	
		if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if ($haslo1!=$haslo2)
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Podane hasła nie są identyczne!";
		}	

		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
		
	
				if ($wszystko_OK==true)
                    {					
				                    
                    if ($polaczenie->query("UPDATE `uzytkownicy` SET `password` = '$haslo_hash' WHERE `uzytkownicy`.`id` = '$istam'"))
					{
                        
						header('Location: wyswietlmojedane.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
				}
				
				$polaczenie->close();
			}
			}
		if (isset($_POST['krajpoch']))
	{	
            $wszystko_OK=true;
		// Sprawdź poprawność adresu email
		$krajpoch = $_POST['krajpoch'];
		 
          if ($wszystko_OK==true)
                    {					
				                    
                    if ($polaczenie->query("UPDATE `profile_images` SET `krajpoch` = '$krajpoch' WHERE `profile_images`.`id` ='$istam';"))//wprowadzanie nowego urzytkownika
					{
						header('Location: wyswietlmojedane.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
				}
				
				$polaczenie->close();
			}  
		if (isset($_POST['slowkilka']))
	{	
            $wszystko_OK=true;
		// Sprawdź poprawność adresu email
		$slowkilka = $_POST['slowkilka'];
		 
          if ($wszystko_OK==true)
                    {					
				                    
                    if ($polaczenie->query("UPDATE `profile_images` SET `slowkilka` = '$slowkilka' WHERE `profile_images`.`id` ='$istam';"))//wprowadzanie nowego urzytkownika
					{
						header('Location: wyswietlmojedane.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
				}
				
				$polaczenie->close();
			} 
			 if (isset($_POST['wyksz']))
	{	
            $wszystko_OK=true;
		// Sprawdź poprawność adresu email
		$wyksz = $_POST['wyksz'];
		 
          if ($wszystko_OK==true)
                    {					
				                    
                    if ($polaczenie->query("UPDATE `profile_images` SET `wyksz` = '$wyksz' WHERE `profile_images`.`id` ='$istam';"))//wprowadzanie nowego urzytkownika
					{
						header('Location: wyswietlmojedane.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
				}
				
				$polaczenie->close();
			} 
				 if (isset($_POST['zain']))
	{	
            $wszystko_OK=true;
		// Sprawdź poprawność adresu email
		$zain = $_POST['zain'];
		 
          if ($wszystko_OK==true)
                    {					
				                    
                    if ($polaczenie->query("UPDATE `profile_images` SET `zain` = '$zain' WHERE `profile_images`.`id` ='$istam';"))//wprowadzanie nowego urzytkownika
					{
						header('Location: wyswietlmojedane.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
				}
				
				$polaczenie->close();
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
     <div class=" tylna_tablica container">
       
         <div class="row">
        <div class="panel panel-dark rej col-md-11 col-lg-4 offset-md-1 tylna_tablica">
            <div class="panel-heading tekstintableuser">Zmien nazwę urzytkownika</div>
            <div class="panel-body">
            <form method="post"> 
		 <input type="text" value="<?php
			if (isset($_SESSION['user']))
			{
				echo $_SESSION['user'];
			}
		?>" name="nick" placeholder="nickname" onfocus="this.placeholder=''" onblur="this.placeholder='nickname'"/><br />
		
		<?php
			if (isset($_SESSION['e_nick']))
			{
				echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
				unset($_SESSION['e_nick']);
			}
		?>
              <input class="zielony_przycisk" type="submit" value="zmień" />
            
                </form>
            </div></div>
        <div class="rej col-md-11 col-lg-4 offset-md-1">
        <div class="panel-heading tekstintableuser">Zmień nazwę urzytkownika</div>
            <div class="panel-body">
            <form method="post"> 
		 <input type="text" value="<?php
			if (isset($_SESSION['email']))
			{
				echo $_SESSION['email'];
			}
		?>" name="email" placeholder="E-mail" onfocus="this.placeholder=''" onblur="this.placeholder='E-mail'"/><br />
		
		<?php
			if (isset($_SESSION['e_email']))
			{
				echo '<div class="error">'.$_SESSION['e_email'].'</div>';
				unset($_SESSION['e_email']);
			}
		?>
		<input class="zielony_przycisk" type="submit" value="zmień" />
            
                </form>
            </div></div>
             <div class="rej col-md-11 col-lg-4 offset-md-1">
        <div class="panel-heading tekstintableuser">Zmień hasło</div>
            <div class="panel-body">
            <form method="post"> 
		<input type="password"  name="haslo0" placeholder="Stare Hasło" onblur="this.placeholder='Stare Hasło'"/>
		
		<?php
			if (isset($_SESSION['e_haslo']))
			{
				echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
				unset($_SESSION['e_haslo']);
			}
		?>		
		<input type="password" name="haslo1" placeholder="Hasło"  onblur="this.placeholder='Hasło'"/>
		
		<?php
			if (isset($_SESSION['e_haslo']))
			{
				echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
				unset($_SESSION['e_haslo']);
			}
		?>		
		<input type="password" name="haslo2" placeholder="Powtórz hasło " onfocus="this.placeholder=''" onblur="this.placeholder='Powtórz hasło '"/>
		<input class="zielony_przycisk" type="submit" value="zmień" />
            
                </form>
            </div></div>
         <div class="panel panel-dark rej col-md-11 col-lg-4 offset-md-1 tylna_tablica">
            <div class="panel-heading tekstintableuser">Zmien aktualne fotografie urzytkownika</div>
            <div class="panel-body">
                <?php 
                $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                $rezultat = $polaczenie->query("SELECT * FROM profile_images WHERE id='$istam'"); 
                $rezultaty=mysqli_fetch_assoc($rezultat);
                ?>
                 <img class="obrazekurzyt " src="obrazkiurzytkownikow/<?php echo $rezultaty['file_name']?>" alt="twatwrzyczka" >
                  <form action="fileuploat.scr.php" method="POST" enctype="multipart/form-data">
                      <input type="file" name="image" />
                      <input class="zielony_przycisk" type="submit" value="zmień" />
                </form>
              
             </div></div>
             <div class="panel panel-dark rej col-md-11 col-lg-4 offset-md-1 tylna_tablica">
            <div class="panel-heading tekstintableuser">Coś o mnie</div>
            <div class="panel-body">
                  <form method="post"> 
                     <input type="text" value="<?php
                        echo $rezultaty['slowkilka'];
                    ?>" name="slowkilka" placeholder="slów kilka" onfocus="this.placeholder=''" onblur="this.placeholder='słów kilka'"/>
                      <input class="zielony_przycisk" type="submit" value="zmień" />
                </form>
              
             </div></div>
             <div class="panel panel-dark rej col-md-11 col-lg-4 offset-md-1 tylna_tablica">
            <div class="panel-heading tekstintableuser">Skod jesteś?</div>
            <div class="panel-body">
                  <form method="post"> 
                     <input type="text" value="<?php
                        echo $rezultaty['krajpoch'];
                    ?>" name="krajpoch" placeholder="kraj pochodzenia" onfocus="this.placeholder=''" onblur="this.placeholder='kraj pochodzenia'"/>
                      <input class="zielony_przycisk" type="submit" value="zmień" />
                </form>

             </div></div>
             <div class="panel panel-dark rej col-md-11 col-lg-4 offset-md-1 tylna_tablica">
            <div class="panel-heading tekstintableuser">jakie masz wykształcenie?</div>
            <div class="panel-body">
                  <form method="post"> 
                      <textarea class="form-control" rows="3" name="wyksz" placeholder="wykształcenie" onfocus="this.placeholder=''" onblur="this.placeholder='wykształcenie'"><?php
                        echo $rezultaty['wyksz'];
                    ?></textarea>
                      <input class="zielony_przycisk" type="submit" value="zmień" />
                </form>
              
             </div></div>
             <div class="panel panel-dark rej col-md-11 col-lg-4 offset-md-1 tylna_tablica">
            <div class="panel-heading tekstintableuser">jakie masz zainteresowania?</div>
            <div class="panel-body">
                  <form method="post"> 
                     <textarea class="form-control" rows="3"  name="zain" placeholder="zainteresowania" onfocus="this.placeholder=''" onblur="this.placeholder='zainteresowania'"><?php
                        echo $rezultaty['zain'];
                         ?></textarea>
                      <input class="zielony_przycisk" type="submit" value="zmień" />
                </form>
              
             </div></div>
             <?php if($_SESSION['status']<1){ ?>
             <div class="panel panel-dark rej col-md-11 col-lg-11 offset-md-1 tylna_tablica">
            <div class="panel-heading tekstintableuser">czy chcesz być moderatorem?</div>
            <div class="panel-body">
                  <form action="czyawans.scr.php" method="post">
                            <input name="username" type="hidden" value="<?php echo $_SESSION['user'] ?>">
                            <input name="submit" type="submit" value="chcę być moderatorem">
                        </form>
              
             </div></div><?php }?>
         </div>
    </div>
    
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
</body>
</html>