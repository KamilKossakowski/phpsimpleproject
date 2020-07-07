<?php
	session_start();	
	session_unset();//wylączenie funkcji przekazywanych za pomocą sesji
	header('Location: index.php');//przekieruj do strony zewnętrznej
?>