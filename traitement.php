<?php
	define('BLOCK','0');
	if (BLOCK == 1) 
		exit('Page bloquée.');
//Ici je vais mettre toutes les fonctions qui reviennent souvent sur le site.
	session_start();
	include('fonctions.php');
	$erreur = '';
	$pseudo = $_POST['pseudo'];
	$pass = $_POST['pass'];
	$passconf = $_POST['passconf'];
	$email = $_POST['email'];
	$date = $_POST['date'];
	//verification pseudo
	$result = mysql_query("SELECT COUNT(*) AS nbr FROM coordonees WHERE pseudo = '".mysql_real_escape_string($pseudo)."'") or die('Erreur MySQL: '.mysql_error().'<br />'.__LINE__);
	$donnees = mysql_fetch_array($result);
	$nombre = $donnees['nbr'];
	if($nombre > 0)  
		$erreur .= 1;
	if (strlen($pseudo) > 15)
		$erreur .= 2;
	//Verification mot de pass
	if (strlen($pass) > 20)
		$erreur .= 3;
	if ($pass != $passconf)
		$erreur .= 4;
	//Verification email
	if (!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#is', $email))
		$erreur .= 5;
	$resultmail = mysql_query("SELECT COUNT(*) AS nbr FROM coordonees WHERE email = '".mysql_real_escape_string($email)."'") or die('Erreur MySQL: '.mysql_error().'<br />'.__LINE__);
	$donneesmail = mysql_fetch_array($resultmail);
	$nombremail = $donneesmail['nbr'];
	if($nombremail > 0)  
		$erreur .= 9;
	if (strlen($email) > 40)
		$erreur .= 6;
	//Verification date
	if (strlen($date) > 10) 
		$erreur .= 7;
	if (!preg_match('#^[0-9]{2}/[0-9]{2}/[0-9]{4}$#is',$date)) 
		$erreur .= 8;
	//Verification captcha
	if ($_SESSION['securecode'] != $_POST['secure']) 
		$erreur .= 'c'.$_SESSION['securecode'];
	//Validation
	if ($erreur == '') {
		include('haut.php');
		$pass = md5($pass);
		mysql_query("INSERT INTO coordonees(`id`,`pseudo`,`mot de pass`,`email`,`date`,`banni`) VALUES('','$pseudo','$pass','$email','$date', '0')") or die('Erreur MySQL: '.mysql_error().'<br />'.__LINE__);
		echo '<center>Inscription réussi !</center>';
		include_once('bas.php');
	}
	else {
		header('Location: http://geek-land.zxq.net/inscription.php?pseudo='.$pseudo.'&pass='.$pass.'&mail='.$email.'&date='.$date.'&erreur='.$erreur);
	}
	include_once('bas.php');
?>