<?php
session_start();


	include("connection.php");
$obj = mysqli_connect($host, $db_user, $db_password, $db_name);
$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
$counta=5;
$offseta=0;
if(isset($_session['counta']))$counta = $_session['counta'];
 if(isset($_session['offseta']))$offseta = $count*$_session['offseta'];
if(isset($_GET['counta'])){
                            $counta = $_GET['counta'];
                           $_session['counta']=$counta;
                          }
 if(isset($_GET['offseta'])){
                                $offseta = $counta*$_GET['offseta'];
                                $_session['offseta']=$offseta ;
                            }
$countk=5;
$offsetk=0;
if(isset($_session['countk']))$countk = $_session['countk'];
 if(isset($_session['offsetk']))$offsetk = $count*$_session['offsetk'];
if(isset($_GET['counta'])){
                            $countk = $_GET['countk'];
                           $_session['countk']=$countk;
                          }
 if(isset($_GET['offsetk'])){
                                $offsetk = $countk*$_GET['offsetk'];
                                $_session['offsetk']=$offsetk ;
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
<div class="container d-md-inline d-sd-inline">
         <div class="row">
        <div class="col-md-11 col-lg-6">
            <div class="pudelko_na_artykuly offset-xl-1 col-sm-10 col-md-10">
                <h3 class="start col-xl-11 offset-xl-1" > Nowe artykuły</h3>
            <?php
                        if ($polaczenie->connect_errno!=0)
                        {
                            throw new Exception(mysqli_connect_errno());
                        }
                        else
                        {         $rezultat = $polaczenie->query("SELECT uzytkownicy.username, posts.title,posts.article,posts.updated_at,posts.created_at,posts.id_pos,posts.user_id_pos,posts.akceptacja FROM `uzytkownicy`,`posts` WHERE uzytkownicy.id=posts.user_id_pos and posts.akceptacja='1' ORDER BY posts.created_at DESC"); 
                                    if (!$rezultat) throw new Exception($polaczenie->error);
                            
                         $row_cnt = $rezultat->num_rows;
                         $pagesa = ceil($row_cnt/$counta);
                          $rezultat2 = $polaczenie->query("SELECT uzytkownicy.username, posts.title,posts.article,posts.updated_at,posts.created_at,posts.id_pos,posts.user_id_pos,posts.akceptacja FROM `uzytkownicy`,`posts` WHERE uzytkownicy.id=posts.user_id_pos and posts.akceptacja='1' ORDER BY posts.created_at DESC Limit $counta offset $offseta"); 
                         if (!$rezultat2) throw new Exception($polaczenie->error);
                            while($row = $rezultat2->fetch_assoc())
                      {  if ($row['user_id_pos']!=$_SESSION['id']){
                       ?>		
                                        <div class=" fic">
                                            <div class="pudelko_w_pudelku col-xl-12">
                                            <h4 class="pudelko_na_tytul"><?php echo $row['title']?></h4>
                                                <h6 class="pudelko_na_autora"> Autorem jest: <?php echo $row['username']?></h6>
                                                <p class="pudelko_na_tresc"><?php  $sk=explode(' ', $row['article'], 19); 
                                                    $sk[18]='...';
                                                  echo implode ( " ",$sk);
                                                ?> </p>
                                                <form  action="texartikul_akceptacja.php" method="post">
                                                <input name="id_pos" type="hidden" value="<?php echo $row["id_pos"] ?>"> 
                                                <input name="submit" type="submit" value="czytaj więcej" class="portol">
                                                </form>
                                                <form action="texuser.php" method="post">
                                                <input name="useridpos" type="hidden" value="<?php echo $row["user_id_pos"] ?>"> 
                                                <input name="submit" type="submit" value="o autorze" class="portol">
                                                </form>
                                                <div class="pudelko_na_date">
                                                <small > Utwożono :<?php echo $row['created_at']?> ostatnia edycja :<?php echo $row['updated_at']?></small>
                                                </div>

                                            </div>
                    </div>
                    <?php
                      } } }
                               ?>
                <div class="pudelko_w_pudelku col-xl-6 offset-xl-3"><?php for($i=0;$i<$pagesa;$i++){
                     //jeśli obecna strona, nie twórz linku do strony
                    if($i*$counta==$offseta){
                            echo ' '.$i.' ';
                    }else{
                    echo '<a href="artykulzak.php?counta='.$counta.'&offseta='.$i.'"> '.$i.' </a>';
                        }
                            }
                               ?> </div>        	
            </div></div>
             <div class="col-md-11 col-lg-6">
             <div class="pudelko_na_artykuly offset-xl-1 col-sm-10 col-md-10">
        <h3 class="start col-xl-11 offset-xl-1" > nowe komentarze:</h3>
    <?php
                if ($polaczenie->connect_errno!=0)
                {
                    throw new Exception(mysqli_connect_errno());
                }
                else                        
                {         $rezultat = $polaczenie->query("SELECT `id_kom`,`id_user`,`id_post`,`tresc`,`wyslano`,`status` FROM `komentarze` WHERE `komentarze`.`status`='1' ORDER BY `komentarze`.`wyslano` DESC"); 
                                    if (!$rezultat) throw new Exception($polaczenie->error);
                            
                         $row_cnt = $rezultat->num_rows;
                         $pagesk = ceil($row_cnt/$countk);
                          $rezultat2 = $polaczenie->query("SELECT `id_kom`,`id_user`,`id_post`,`tresc`,`wyslano`,`status` FROM `komentarze` WHERE `komentarze`.`status`='1' ORDER BY `komentarze`.`wyslano` DESC Limit $countk offset $offsetk"); 
                         if (!$rezultat2) throw new Exception($polaczenie->error);
                            while($row = $rezultat2->fetch_assoc())
              { 
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
                                                <form class="pudelko_na_tytul col-lg-1" method="post" action="koment.akc.scr.php"> 
                                                     <input name="useridpos" type="hidden" value="<?php echo $row["id_kom"] ?>"> 
                                                    <input name="submit" type="submit" value="akceptuj" class="portol">
                                                    </form>
                                                <form class="pudelko_na_tytul col-lg-1" method="post" action="koment.noakc.scr.php"> 
                                                     <input name="useridpos" type="hidden" value="<?php echo $row["id_kom"] ?>"> 
                                                    <input name="submit" type="submit" value="nie" class="portol">
                                                    </form>
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
                                 <div class="pudelko_w_pudelku col-xl-6 offset-xl-3"><?php for($i=0;$i<$pagesk;$i++){
                     //jeśli obecna strona, nie twórz linku do strony
                    if($i*$countk==$offsetk){
                            echo ' '.$i.' ';
                    }else{
                    echo '<a href="artykulzak.php?countk='.$countk.'&offsetk='.$i.'"> '.$i.' </a>';
                        }
                            }
                               ?> </div> 
          </div>            
             
             </div>
        </div>
</div>
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>	
	

</body>
</html>