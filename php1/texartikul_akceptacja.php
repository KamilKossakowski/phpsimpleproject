<?php
session_start();
include("connection.php");
$obj = mysqli_connect($host, $db_user, $db_password, $db_name);

if (isset($_POST['id_pos']))
	{
		$idposta=$_POST['id_pos'];
        $_SESSION['id_posta']=$_POST['id_pos'];
    
	}else{
		$idposta=$_SESSION['id_posta'];
    
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
		<div class="container d-md-inline d-sd-inline">
         <div class="row">
        <div class="col-md-11 col-lg-12">
            <div class="pudelko_na_artykuly offset-xl-1 col-sm-10 col-md-10">
            <?php
                        if ($polaczenie->connect_errno!=0)
                        {
                            throw new Exception(mysqli_connect_errno());
                        }
                        else
                        {         $rezultat = $polaczenie->query("SELECT uzytkownicy.username, posts.title,posts.article,posts.updated_at,posts.created_at,posts.id_pos,posts.user_id_pos FROM `uzytkownicy`,`posts` WHERE uzytkownicy.id=posts.user_id_pos and posts.id_pos='$idposta'"); 
                                    if (!$rezultat) throw new Exception($polaczenie->error);
                            $i=0;
                            while($row = $rezultat->fetch_assoc())
                      { $i++;
                       ?>		
                                        <div class=" fic">
                                            <div class="pudelko_w_pudelku col-xl-12">
                                              <div class="row">   
                                            <h4 class="pudelko_na_tytul col-lg-8"><?php echo $row['title']?></h4>
                                                  <?php if(isset($_SESSION['zalogowany'])){if((($row['username']==$_SESSION['user'])||($_SESSION['status']>1))&&($_SESSION['ban']!=false)){ ?>
                                                 <form class="pudelko_na_tytul col-lg-1" method="post" action="akceptacja_art.scr.php"> 
                                                     <input name="id_pos" type="hidden" value="<?php echo $row["id_pos"] ?>"> 
                                                    <input name="submit" type="submit" value="akceptuj" class="portol">
                                                </form><?php }} ?>
                                                  <?php if(isset($_SESSION['zalogowany'])){if((($row['username']==$_SESSION['user'])||($_SESSION['status']>1))&&($_SESSION['ban']!=false)){ ?>
                                                 <form class="pudelko_na_tytul col-lg-1" method="post" action="nie_akceptacja_art.scr.php"> 
                                                     <input name="id_pos" type="hidden" value="<?php echo $row["id_pos"] ?>"> 
                                                    <input name="submit" type="submit" value="odrzuć" class="portol">
                                                </form><?php }} ?>
                                                  <?php if(isset($_SESSION['zalogowany'])){if((($row['username']==$_SESSION['user'])||($_SESSION['status']>1))&&($_SESSION['ban']!=false)){ ?>
                                                 <form class="pudelko_na_tytul col-lg-1" method="post" action="texartikul_edit.scr.php"> 
                                                     <input name="id_pos" type="hidden" value="<?php echo $row["id_pos"] ?>"> 
                                                    <input name="submit" type="submit" value="edytuj" class="portol">
                                                </form><?php }} ?>
                                                  <?php if(isset($_SESSION['zalogowany'])){if((($row['username']==$_SESSION['user'])||($_SESSION['status']>1))&&($_SESSION['ban']!=false)){ ?>
                                                <form class="pudelko_na_tytul col-lg-1" method="post" action="texartikul_deat.scr.php"> 
                                                     <input name="useridpos" type="hidden" value="<?php echo $row["id_pos"] ?>"> 
                                                    <input name="submit" type="submit" value="usuń" class="portol">
                                                  </form><?php } }?></div>
                                                <h6 class="pudelko_na_autora"> Autorem jest: <?php echo $row['username']?></h6>
                                                <p class="pudelko_na_tresc"><?php echo $row['article']
                                                ?> </p>
                                                
                                                <div class="pudelko_na_date">
                                                <small > Utwożono :<?php echo $row['created_at']?> ostatnia edycja :<?php echo $row['updated_at']?></small>
                                                </div>

                                            </div>
                    </div>
                    <?php
                        }}
                               ?>    	
            </div>
               <div class="pudelko_na_artykuly offset-xl-1 col-sm-10 col-md-10">
        <h3 class="start col-xl-11 offset-xl-1" > nowe komentarze:</h3>
    <?php
                if ($polaczenie->connect_errno!=0)
                {
                    throw new Exception(mysqli_connect_errno());
                }
                else
                {         $rezultat = $polaczenie->query("SELECT `id_kom`,`id_user`,`id_post`,`tresc`,`wyslano`,`status` FROM `komentarze`where id_post='$idposta' ORDER BY `komentarze`.`wyslano` DESC");
                        
                            if (!$rezultat) throw new Exception($polaczenie->error);
                    $i=0;
                    while($row = $rezultat->fetch_assoc())
              { $i++;
               $idu=$row["id_user"];
               $idp=$row["id_post"];
               		$rezuser=$polaczenie->query("SELECT `username` FROM `uzytkownicy` WHERE id='$idu' ");
                    $rezpos=$polaczenie->query("SELECT uzytkownicy.username,posts.id_pos, posts.title,posts.article,posts.updated_at,posts.created_at FROM `uzytkownicy`,`posts` WHERE (uzytkownicy.id=posts.user_id_pos AND posts.id_pos='$idp')");
               $rezu=mysqli_fetch_assoc($rezuser);
               $rezp=mysqli_fetch_assoc($rezpos);
            ?>
                                        <div class=" fic">
                                            <div class="pudelko_w_pudelku col-xl-12">
                                                <div class="row">
                                            <h4 class="pudelko_na_tytul col-lg-11">Artykuł <?php echo $rezp['title']?></h4>
                                                    <?php if((($rezu['username']==$_SESSION['user'])||($_SESSION['status']>1))&&($_SESSION['ban']!=false)){ ?>
                                                <form class="pudelko_na_tytul col-lg-1" method="post" action="koment.del.scr.php"> 
                                                     <input name="useridpos" type="hidden" value="<?php echo $row["id_kom"] ?>"> 
                                                    <input name="submit" type="submit" value="usuń" class="portol">
                                                    </form><?php } ?></div>
                                                <h6 class="pudelko_na_autora"> Autorem komentarza jest: <?php echo $rezu['username'] ?></h6>
                                                <p class="pudelko_na_tresc"><?php echo $row['tresc']
                                                ?> </p>
                                                <div class="pudelko_na_date">
                                                <small > Utwożono :<?php echo $row['wyslano']?></small>
                                                </div>

                                            </div>
                    </div>

                <?php
                    }}
                           ?>    	
          </div></div>
            </div>
        <?php
           if ((isset($_SESSION['zalogowany']))&&(isset($_SESSION['ban'])))
	{ if($_SESSION['ban']!=false){?>
             <div class="panel panel-dark rej col-md-11 col-lg-10 offset-md-1 tylna_tablica">
            <div class="panel-body">
                  <form method="post"> 
                     <textarea class="form-control" rows="8"  name="com_new" placeholder="tresc twojego komentarza" onfocus="this.placeholder=''" onblur="this.placeholder='tresc twojego komentarza'"> </textarea>
                      <input class="zielony_przycisk" type="submit" value="skomentuj" />
                </form>
              
             </div></div><?php } } ?>
    </div>
 
     <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
    </body>
	
</html>