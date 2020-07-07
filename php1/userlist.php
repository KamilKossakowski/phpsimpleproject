<?php
session_start();
include("connection.php");
$obj = mysqli_connect($host, $db_user, $db_password, $db_name);
if ((!isset($_SESSION['zalogowany']))||($_SESSION['status']<'2')||($_SESSION['ban']==false))
	{
		header('Location: index.php');
		exit();
	}

?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
	<title>Java -programujmy</title>
    <meta name="description" content="Serwis zrzeszający programistów języka Java" />
	<meta name="keywords" content="java, komputerowe, programiści, kod, dyskusja, programy" />
      <link rel="stylesheet" href="css/bootstrap.min.css">
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
    <div class="rej col-sm-6 col-md-5 offset-xl-4 offset-sm-4">
    <table class="tekstintableuser">
        <tr><h3>Panel zarzadzania uzytkownikami</h3></tr>
		  
		  <tr>
		      <td>Username</td>
		      <td>Status</td>
		      <td>Ban</td>
              <td>Zmiana statusu</td>
              <td>usuń</td>
		  </tr>
		  
		  
<?php
		  $result = $obj->query("SELECT * FROM uzytkownicy");
		  
		  while($row = $result->fetch_assoc())
		  {
		      
		       ?><tr style="font-family: monospace monospace">
                        <td><?php echo $row["username"]?> </td>
			            <td>  <?php if($row["status"]=='0'){  ?> zwykły urzytkownik
                                                  <?php }elseif($row["status"]=='1'){ ?>Aplikant na moderatora;
                                                                            <?php }elseif($row["status"]=='2'){ ?>Moderator
                                                                                                            <?php }else{ ?> administrator
                            <?php }
              
                            
                            ?> 
                        </td>
                       <?php  if($row["status"]!='3'){
                            if($row["banned"]!='true'){?>
			            <td><form action="ban.scr.php" method="post">
                            <input name="username" type="hidden" value="<?php echo $row["username"] ?>">
                            <input name="submit" type="submit" value="ban">
                        </form>
                        </td><?php }else{ ?>
                        <td><form action="unban.scr.php" method="post">
                            <input name="username" type="hidden" value="<?php echo $row["username"] ?>"> 
                            <input name="submit" type="submit" value="unban" class="portol">
                        </form>
                        </td><?php }if(($_SESSION['status']>'1')&&(($row["status"]=='1')||($row["status"]=='2'))){
                               
                                if($row["status"]=='1'){
                            if($row["banned"]!='true'){?>
			            <td><form action="awans.scr.php" method="post">
                            <input name="username" type="hidden" value="<?php echo $row["username"]?>">
                            <input name="submit" type="submit" value="awans">
                        </form>
                        </td><?php }}?>
                        <?php  if($row["status"]=='2'&&$_SESSION['status']>'2'){
                            if($row["banned"]!='true'){?>
			            <td><form action="unawans.scr.php" method="post">
                            <input name="username" type="hidden" value="<?php echo $row["username"] ?>">
                            <input name="submit" type="submit" value="degradacja">
                        </form>
                        </td><?php }}}else{ ?>
        <td></td>
                        <?php }if($_SESSION['status']>'2'){
                            if($row["banned"]!='true'){?>
			            <td><form action="usun.scr.php" method="post">
                            <input name="username" type="hidden" value="<?php echo $row["username"] ?>">
                            <input name="submit" type="submit" value="usunięcie">
                        </form>
                        </td><?php }} ?>
		            </tr><?php
		      }}
		  
		  
		  ?>
		  
		
    </table>
        </div>
     <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
    </body>
	
</html>