<?php

	session_start();
	
	if (!isset($_SESSION['udanarejestracja']))
	{
		header('Location: index.php');
		exit();
	}
	else
	{
		unset($_SESSION['udanarejestracja']);
	}
	
	//czyszczenie niepotrzebnych danych powstałych przy prowadzeniu rejestracji
	if (isset($_SESSION['formularz_rejestracji_nick'])) unset($_SESSION['formularz_rejestracji_nick']);
	if (isset($_SESSION['formularz_rejestracji_email'])) unset($_SESSION['formularz_rejestracji_email']);
	if (isset($_SESSION['formularzr_ejestracji_haslo1'])) unset($_SESSION['formularz_rejestracji_haslo1']);
	if (isset($_SESSION['formularzr_ejestracji_haslo2'])) unset($_SESSION['formularz_rejestracji_haslo2']);
	if (isset($_SESSION['formularzr_ejestracji_regulamin'])) unset($_SESSION['formularz_rejestracji_regulamin']);
	
	if (isset($_SESSION['e_nick'])) unset($_SESSION['e_nick']);
	if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
	if (isset($_SESSION['e_haslo'])) unset($_SESSION['e_haslo']);
	if (isset($_SESSION['e_regulamin'])) unset($_SESSION['e_regulamin']);
	if (isset($_SESSION['e_bot'])) unset($_SESSION['e_bot']);
	
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
	
	<form class="rej" method="post">
	<p class="witaj">Dziękujemy za rejestrację w serwisie! Możesz już zalogować się na swoje konto!</p><br /><br />
	<input class="czerwony_przycisk" type="button" value="Ok!" onClick="location.href='index.php';"/>
	Ok!
	</form>
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
</body>
</html>