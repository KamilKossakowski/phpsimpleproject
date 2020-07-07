<?php

	session_start();
   	if (isset($_POST['email']))
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
		
		// Sprawdź poprawność adresu email
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);//transformacja napisanego e-maila na kodowany email
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))//jeśli wykonana poprawę w nazwie i długość się zmieniła
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}
		
		//Sprawdź poprawność hasła
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		
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
		
		//Czy zaakceptowano regulamin?
		if (!isset($_POST['regulamin']))
		{
			$wszystko_OK=false;
			$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
		}				
		
		$sekret = "6LeH6XkUAAAAAJGV6ijcz-5EPtqc47tvaNZgPALS";
		
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		
		$odp = json_decode($sprawdz);
		
		if ($odp->success==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
		}		
		
		//Zapamiętaj wprowadzone dane
		$_SESSION['formularz_rejestracji_nick'] = $nick;
		$_SESSION['formularz_rejestracji'] = $email;
		$_SESSION['formularz_rejestracji_haslo1'] = $haslo1;
		$_SESSION['formularz_rejestracji_haslo2'] = $haslo2;
		if (isset($_POST['regulamin'])) $_SESSION['formularz_rejestracji_regulamin'] = true;
		
		require_once "connection.php";
		
		try 
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//Czy email już istnieje?
				$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}		

				//Czy nick jest już zarezerwowany?
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
				                    
                    if ($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$nick', '$haslo_hash', '$email',NOW(),'folse','0')"))//wprowadzanie nowego urzytkownika
					{
                        $polaczenie->query("INSERT INTO profile_images VALUES (NULL,'iampopeye.png',NULL,NULL,NULL,NULL)");
						$_SESSION['udanarejestracja']=true;
						header('Location: witamy.php');
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
		
	}
	
	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Java -programujmy</title>
    <meta name="description" content="Serwis zrzeszający programistów języka Java" />
	<meta name="keywords" content="java, komputerowe, programiści, kod, dyskusja, programy" />
	<script src='https://www.google.com/recaptcha/api.js'></script>
      <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="style.css" rel="stylesheet" type="text/css" />
	
	
</head>

<body class="tyl">
     <div class=" container">
       
         <div class="row">
        
        <div class=" col-sm-6 col-md-5 offset-md-3">
           <div class="rej">
<form class="logres_pojemnik" method="post">
	       
		 <input type="text" class="fic" value="<?php
			if (isset($_SESSION['formularz_rejestracji_nick']))
			{
				echo $_SESSION['formularz_rejestracji_nick'];
				unset($_SESSION['formularz_rejestracji_nick']);
			}
		?>" name="nick" placeholder="nickname" onfocus="this.placeholder=''" onblur="this.placeholder='nickname'"/><br />
		
		<?php
			if (isset($_SESSION['e_nick']))
			{
				echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
				unset($_SESSION['e_nick']);
			}
		?>
		
		 <input type="text" class="fic" value="<?php
			if (isset($_SESSION['formularz_rejestracji_email']))
			{
				echo $_SESSION['formularz_rejestracji_email'];
				unset($_SESSION['formularz_rejestracji_email']);
			}
		?>" name="email" placeholder="E-mail" onfocus="this.placeholder=''" onblur="this.placeholder='E-mail'"/><br />
		
		<?php
			if (isset($_SESSION['e_email']))
			{
				echo '<div class="error">'.$_SESSION['e_email'].'</div>';
				unset($_SESSION['e_email']);
			}
		?>
		
		<input type="password" class="fic" value="<?php
			if (isset($_SESSION['formularz_rejestracji_haslo1']))
			{
				echo $_SESSION['formularz_rejestracji_haslo1'];
				unset($_SESSION['formularz_rejestracji_haslo1']);
			}
		?>" name="haslo1" placeholder="Hasło" onfocus="this.placeholder=''" onblur="this.placeholder='Hasło'"/>
		
		<?php
			if (isset($_SESSION['e_haslo']))
			{
				echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
				unset($_SESSION['e_haslo']);
			}
		?>		
		
		<input type="password" class="fic" value="<?php
			if (isset($_SESSION['formularz_rejestracji_haslo2']))
			{
				echo $_SESSION['formularz_rejestracji_haslo2'];
				unset($_SESSION['formularz_rejestracji_haslo2']);
			}
		?>" name="haslo2" placeholder="Powtórz hasło " onfocus="this.placeholder=''" onblur="this.placeholder='Powtórz hasło '"/>
		
		<p><label>
			<input type="checkbox" name="regulamin" class= "regulamin" <?php
			if (isset($_SESSION['formularz_rejestracji_regulamin']))
			{
				echo "checked";
				unset($_SESSION['formularz_rejestracji_regulamin']);
			}
				?>/> Akceptuję regulamin
		</label></p>
		
		<?php
			if (isset($_SESSION['e_regulamin']))
			{
				echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
				unset($_SESSION['e_regulamin']);
			}
		?>	
		
		<div class="g-recaptcha" data-sitekey="6LeH6XkUAAAAAPeEneCRbnkwFsFId5qwC7VmBL8u"></div>
		
		<?php
			if (isset($_SESSION['e_bot']))
			{
				echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
				unset($_SESSION['e_bot']);
			}
		?>	
		
		<br />
		
		<input class="zielony_przycisk" type="submit" value="Zarejestruj się" />
		<input class="czerwony_przycisk" type="button" value="Zrezygnuj" onClick="location.href='index.php';"/>
        
	</form>
            </div></div></div></div>
    
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
</body>
</html>