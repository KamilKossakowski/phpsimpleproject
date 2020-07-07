<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	include("connection.php");
$obj = mysqli_connect($host, $db_user, $db_password, $db_name);
$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
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
    <?php if(isset($_SESSION['ban'])){if($_SESSION['ban']==false){ ?><h2 class="error"> You are banned</h2><?php }}
    $userid=$_SESSION['id'];
    ?>
    <div class="container d-md-inline d-sd-inline">
         <div class="row">
  
        <div class="col-md-10 col-lg-4">
            <div class="pudelko_na_artykuly offset-xl-1 col-sm-10 col-md-10">
                <h3 class="start col-xl-11 offset-xl-1" > Zaakceptowane artykuły</h3>
            <?php
                        if ($polaczenie->connect_errno!=0)
                        {
                            throw new Exception(mysqli_connect_errno());
                        }
                        else
                        {        $rezultat = $polaczenie->query("SELECT uzytkownicy.username, posts.title,posts.article,posts.updated_at,posts.created_at,posts.akceptacja,posts.id_pos,posts.user_id_pos FROM `uzytkownicy`,`posts` WHERE uzytkownicy.id=posts.user_id_pos and uzytkownicy.id='$userid' ORDER BY posts.created_at DESC");
                                    if (!$rezultat) throw new Exception($polaczenie->error);
                            $i=0;
                            while(($row = $rezultat->fetch_assoc())&&($i<4))
                      {if($row['akceptacja']==2){ $i++;
                       ?>		
                                        <div class=" fic">
                                            <div class="pudelko_w_pudelku col-xl-12">
                                            <h4 class="pudelko_na_tytul"><?php echo $row['title']?></h4>
                                                <h6 class="pudelko_na_autora"> Autorem jest: <?php echo $row['username']?></h6>
                                                <p class="pudelko_na_tresc"><?php  $sk=explode(' ', $row['article'], 19); 
                                                    $sk[18]='...';
                                                  echo implode ( " ",$sk);
                                                ?> </p>
                                                <form  action="texartikul.php" method="post">
                                                <input name="id_pos" type="hidden" value="<?php echo $row["id_pos"] ?>"> 
                                                <input name="submit" type="submit" value="czytaj więcej" class="portol">
                                                </form>
                                                <form action="texuser.php" method="post">
                                                <input name="user_id_pos" type="hidden" value="<?php echo $row["user_id_pos"] ?>"> 
                                                <input name="submit" type="submit" value="o autorze" class="portol">
                                                </form>
                                                <div class="pudelko_na_date">
                                                <small > Utwożono :<?php echo $row['created_at']?> ostatnia edycja :<?php echo $row['updated_at']?></small>
                                                </div>

                                            </div>
                    </div>
                    <?php
                        }}}
                               ?>    	
            </div></div>
             <div class="col-md-10 col-lg-4">
            <div class="pudelko_na_artykuly offset-xl-1 col-sm-10 col-md-10">
                <h3 class="start col-xl-11 offset-xl-1" > Zaakceptowane artykuły</h3>
            <?php
                        if ($polaczenie->connect_errno!=0)
                        {
                            throw new Exception(mysqli_connect_errno());
                        }
                        else
                        {        $rezultat = $polaczenie->query("SELECT uzytkownicy.username, posts.title,posts.article,posts.updated_at,posts.created_at,posts.akceptacja,posts.id_pos,posts.user_id_pos FROM `uzytkownicy`,`posts` WHERE uzytkownicy.id=posts.user_id_pos and uzytkownicy.id='$userid' ORDER BY posts.created_at DESC");
                                    if (!$rezultat) throw new Exception($polaczenie->error);
                            $i=0;
                            while(($row = $rezultat->fetch_assoc())&&($i<4))
                      {if($row['akceptacja']==2){ $i++;
                       ?>		
                                        <div class=" fic">
                                            <div class="pudelko_w_pudelku col-xl-12">
                                            <h4 class="pudelko_na_tytul"><?php echo $row['title']?></h4>
                                                <h6 class="pudelko_na_autora"> Autorem jest: <?php echo $row['username']?></h6>
                                                <p class="pudelko_na_tresc"><?php  $sk=explode(' ', $row['article'], 19); 
                                                    $sk[18]='...';
                                                  echo implode ( " ",$sk);
                                                ?> </p>
                                                <form  action="texartikul.php" method="post">
                                                <input name="id_pos" type="hidden" value="<?php echo $row["id_pos"] ?>"> 
                                                <input name="submit" type="submit" value="czytaj więcej" class="portol">
                                                </form>
                                                <form action="texuser.php" method="post">
                                                <input name="user_id_pos" type="hidden" value="<?php echo $row["user_id_pos"] ?>"> 
                                                <input name="submit" type="submit" value="o autorze" class="portol">
                                                </form>
                                                <div class="pudelko_na_date">
                                                <small > Utwożono :<?php echo $row['created_at']?> ostatnia edycja :<?php echo $row['updated_at']?></small>
                                                </div>

                                            </div>
                    </div>
                    <?php
                        }}}
                               ?>    	
            </div></div>
         <div class="col-md-10 col-lg-4">
            <div class="pudelko_na_artykuly offset-xl-1 col-sm-10 col-md-10">
                <h3 class="start col-xl-11 offset-xl-1" > Oczekujące na akceptację artykuły</h3>
            <?php
                        if ($polaczenie->connect_errno!=0)
                        {
                            throw new Exception(mysqli_connect_errno());
                        }
                        else
                        {        $rezultat = $polaczenie->query("SELECT uzytkownicy.username, posts.title,posts.article,posts.updated_at,posts.created_at,posts.akceptacja,posts.id_pos,posts.user_id_pos FROM `uzytkownicy`,`posts` WHERE uzytkownicy.id=posts.user_id_pos and uzytkownicy.id='$userid' ORDER BY posts.created_at DESC");
                                    if (!$rezultat) throw new Exception($polaczenie->error);
                            $i=0;
                            while(($row = $rezultat->fetch_assoc())&&($i<4))
                      {if($row['akceptacja']==1){ $i++;
                       ?>		
                                        <div class=" fic">
                                            <div class="pudelko_w_pudelku col-xl-12">
                                            <h4 class="pudelko_na_tytul"><?php echo $row['title']?></h4>
                                                <h6 class="pudelko_na_autora"> Autorem jest: <?php echo $row['username']?></h6>
                                                <p class="pudelko_na_tresc"><?php  $sk=explode(' ', $row['article'], 19); 
                                                    $sk[18]='...';
                                                  echo implode ( " ",$sk);
                                                ?> </p>
                                                <form  action="texartikul.php" method="post">
                                                <input name="id_pos" type="hidden" value="<?php echo $row["id_pos"] ?>"> 
                                                <input name="submit" type="submit" value="czytaj więcej" class="portol">
                                                </form>
                                                <form action="texuser.php" method="post">
                                                <input name="user_id_pos" type="hidden" value="<?php echo $row["user_id_pos"] ?>"> 
                                                <input name="submit" type="submit" value="o autorze" class="portol">
                                                </form>
                                                <div class="pudelko_na_date">
                                                <small > Utwożono :<?php echo $row['created_at']?> ostatnia edycja :<?php echo $row['updated_at']?></small>
                                                </div>

                                            </div>
                    </div>
                    <?php
                        }}}
                               ?>    	
            </div></div>
        
      <div class="col-md-10 col-lg-4">
        <div class="pudelko_na_artykuly offset-xl-1 col-sm-10 col-md-10">
        <h3 class="start col-xl-11 offset-xl-1" > zaakceptowane komentarze:</h3>
    <?php
                if ($polaczenie->connect_errno!=0)
                {
                    throw new Exception(mysqli_connect_errno());
                }
                else
                {         $rezultat = $polaczenie->query("SELECT `id_user`,`id_post`,`tresc`,`wyslano`,`status` FROM `komentarze` WHERE `komentarze`.`status`='2' and `komentarze`.`id_user`='$userid' ORDER BY `komentarze`.`wyslano` DESC");
                            if (!$rezultat) throw new Exception($polaczenie->error);
                    $i=0;
                    while(($row = $rezultat->fetch_assoc())&&($i<4))
              { $i++;
               $idu=$row["id_user"];
               $idp=$row["id_post"];
               		$rezuser=$polaczenie->query("SELECT `username`,`id` FROM `uzytkownicy` WHERE id='$idu' ");
                    $rezpos=$polaczenie->query("SELECT uzytkownicy.username, posts.title,posts.article,posts.updated_at,posts.created_at FROM `uzytkownicy`,`posts` WHERE (uzytkownicy.id=posts.user_id_pos AND posts.id_pos='$idp')");
               $rezu=mysqli_fetch_assoc($rezuser);
               $rezp=mysqli_fetch_assoc($rezpos);
            ?>
                                        <div class=" fic">
                                            <div class="pudelko_w_pudelku col-xl-12">
                                            <h4 class="pudelko_na_tytul">Artykuł <?php echo $rezp['title']?></h4>
                                                <h6 class="pudelko_na_autora"> Autorem komentarza jest: <?php echo $rezu['username'] ?></h6>
                                                <p class="pudelko_na_tresc"><?php  $sk=explode(' ', $row['tresc'], 10); 
                                                    $sk[9]='...';
                                                  echo implode ( " ",$sk);
                                                ?> </p>
                                                <form action="texuser.php" method="post">
                                                <input name="useridpos" type="hidden" value="<?php echo $rezu['id'] ?>"> 
                                                <input name="submit" type="submit" value="o autorze" >
                                                 </form>   
                                                <div class="pudelko_na_date">
                                                <small > Utwożono :<?php echo $row['wyslano']?></small>
                                                </div>
                                            </div>
                                                
                    </div>

                <?php
                    }}
                           ?>    	
          </div></div>
                   <div class="col-md-10 col-lg-4">
        <div class="pudelko_na_artykuly offset-xl-1 col-sm-10 col-md-10">
        <h3 class="start col-xl-11 offset-xl-1" > odrzucone komentarze:</h3>
    <?php
                if ($polaczenie->connect_errno!=0)
                {
                    throw new Exception(mysqli_connect_errno());
                }
                else
                {         $rezultat = $polaczenie->query("SELECT `id_user`,`id_post`,`tresc`,`wyslano`,`status` FROM `komentarze` WHERE `komentarze`.`status`='0' and `komentarze`.`id_user`='$userid' ORDER BY `komentarze`.`wyslano` DESC");
                            if (!$rezultat) throw new Exception($polaczenie->error);
                    $i=0;
                    while(($row = $rezultat->fetch_assoc())&&($i<4))
              { $i++;
               $idu=$row["id_user"];
               $idp=$row["id_post"];
               		$rezuser=$polaczenie->query("SELECT `username`,`id` FROM `uzytkownicy` WHERE id='$idu' ");
                    $rezpos=$polaczenie->query("SELECT uzytkownicy.username, posts.title,posts.article,posts.updated_at,posts.created_at FROM `uzytkownicy`,`posts` WHERE (uzytkownicy.id=posts.user_id_pos AND posts.id_pos='$idp')");
               $rezu=mysqli_fetch_assoc($rezuser);
               $rezp=mysqli_fetch_assoc($rezpos);
            ?>
                                        <div class=" fic">
                                            <div class="pudelko_w_pudelku col-xl-12">
                                            <h4 class="pudelko_na_tytul">Artykuł <?php echo $rezp['title']?></h4>
                                                <h6 class="pudelko_na_autora"> Autorem komentarza jest: <?php echo $rezu['username'] ?></h6>
                                                <p class="pudelko_na_tresc"><?php  $sk=explode(' ', $row['tresc'], 10); 
                                                    $sk[9]='...';
                                                  echo implode ( " ",$sk);
                                                ?> </p>
                                                <form action="texuser.php" method="post">
                                                <input name="useridpos" type="hidden" value="<?php echo $rezu['id'] ?>"> 
                                                <input name="submit" type="submit" value="o autorze" >
                                                 </form>   
                                                <div class="pudelko_na_date">
                                                <small > Utwożono :<?php echo $row['wyslano']?></small>
                                                </div>
                                            </div>
                                                
                    </div>

                <?php
                    }}
                           ?>    	
          </div></div> 
             <div class="col-md-10 col-lg-4">
        <div class="pudelko_na_artykuly offset-xl-1 col-sm-10 col-md-10">
        <h3 class="start col-xl-11 offset-xl-1" >czekające na zaakceptowane komentarze:</h3>
    <?php
                if ($polaczenie->connect_errno!=0)
                {
                    throw new Exception(mysqli_connect_errno());
                }
                else
                {         $rezultat = $polaczenie->query("SELECT `id_user`,`id_post`,`tresc`,`wyslano`,`status` FROM `komentarze` WHERE `komentarze`.`status`='2' and `komentarze`.`id_user`='$userid' ORDER BY `komentarze`.`wyslano` DESC");
                            if (!$rezultat) throw new Exception($polaczenie->error);
                    $i=0;
                    while(($row = $rezultat->fetch_assoc())&&($i<4))
              { $i++;
               $idu=$row["id_user"];
               $idp=$row["id_post"];
               		$rezuser=$polaczenie->query("SELECT `username`,`id` FROM `uzytkownicy` WHERE id='$idu' ");
                    $rezpos=$polaczenie->query("SELECT uzytkownicy.username, posts.title,posts.article,posts.updated_at,posts.created_at FROM `uzytkownicy`,`posts` WHERE (uzytkownicy.id=posts.user_id_pos AND posts.id_pos='$idp')");
               $rezu=mysqli_fetch_assoc($rezuser);
               $rezp=mysqli_fetch_assoc($rezpos);
            ?>
                                        <div class=" fic">
                                            <div class="pudelko_w_pudelku col-xl-12">
                                            <h4 class="pudelko_na_tytul">Artykuł <?php echo $rezp['title']?></h4>
                                                <h6 class="pudelko_na_autora"> Autorem komentarza jest: <?php echo $rezu['username'] ?></h6>
                                                <p class="pudelko_na_tresc"><?php  $sk=explode(' ', $row['tresc'], 10); 
                                                    $sk[9]='...';
                                                  echo implode ( " ",$sk);
                                                ?> </p>
                                                <form action="texuser.php" method="post">
                                                <input name="useridpos" type="hidden" value="<?php echo $rezu['id'] ?>"> 
                                                <input name="submit" type="submit" value="o autorze" >
                                                 </form>   
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
</div>
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>	
	

</body>
</html>