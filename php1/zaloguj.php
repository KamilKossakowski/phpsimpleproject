<?php

	session_start();
if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: stronapierwsza.php');
		exit();
	}
if (isset($_POST['login']))
	{
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
			$login = $_POST['login'];
			$haslo = $_POST['haslo'];
			
			$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		
			if ($rezultat = $polaczenie->query(
			sprintf("SELECT * FROM uzytkownicy WHERE username='%s'",//%s - oznaca to powałanie do tego miejsca odpowiednią wartość po przecinku
			mysqli_real_escape_string($polaczenie,$login))))
			{
				$ilu_userow = $rezultat->num_rows;
				if($ilu_userow>0)
				{
					$wiersz = $rezultat->fetch_assoc();
					
					if (password_verify($haslo, $wiersz['password']))
					{
						$_SESSION['zalogowany'] = true;
						$_SESSION['id'] = $wiersz['id'];
						$_SESSION['user'] = $wiersz['username'];
						$_SESSION['email'] = $wiersz['email'];
                        $_SESSION['status'] = $wiersz['status'];
                        $_SESSION['ban'] = $wiersz['banned'];
						unset($_SESSION['blad']);
						$rezultat->free_result();
						header('Location: stronapierwsza.php');
					}
					else 
					{
						$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
						
					}
					
				} else {
					
					$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
					
					
				}
				
			}
			else
			{
				throw new Exception($polaczenie->error);
			}
			
			$polaczenie->close();
		}
	}
	catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o wizytę w innym terminie!</span>';
		echo '<br />Informacja developerska: '.$e;
	}}
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
     <div class=" container">
       
         <div class="row">
        
        <div class=" col-sm-6 col-md-5 offset-md-3">
           <div class="rej">
<form class="logres_pojemnik" method="post">
        <input type="text" name="login" placeholder="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'" /> 
		 <input type="password" name="haslo" placeholder="hasło" onfocus="this.placeholder=''" onblur="this.placeholder='hasło'"/> 
		<input class="zielony_przycisk" type="submit" value="Zarejestruj się" />
		<input class="czerwony_przycisk" type="button" value="Zrezygnuj" onClick="location.href='index.php';"/>
    </form>
            </div> </div></div></div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
    </body>