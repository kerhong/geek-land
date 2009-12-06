<?php
	session_start();
	define( 'ROOT_URL', 'http://geek-land.zxq.net' );
	define( 'BLOCK', '0' );
	if( BLOCK == 1 )
		{
			exit( 'Page bloquée.' );
		}
//Ici je vais mettre toutes les fonctions qui reviennent souvent sur le site.
	require_once 'lib/fonctions' . PHP_EXT;
	$erreur = array();
	if( !isset( $_POST['pseudo'] ) || !isset( $_POST['pass'] ) || !isset( $_POST['passconf'] ) || !isset( $_POST['email'] ) || !isset( $_POST['date'] ) )
	{
		$erreur[] = 0;
	}
	$pseudo = bdd::secure( $_POST['pseudo'] );
	$pass = bdd::secure( $_POST['pass'] );
	$passconf = bdd::secure( $_POST['passconf'] );
	$email = bdd::secure( $_POST['email'] );
	$date = bdd::secure( $_POST['date'] );
	//verification pseudo
	$result = bdd::query('SELECT COUNT(*) AS nbr FROM coordonees WHERE pseudo = \'' . $pseudo . '\'');
	$donnees = bdd::fetch( $result, 'array' );
	$nombre = $donnees['nbr'];
	if( $nombre > 0 )
	{
		$erreur[] = 1;
	}
	if( strlen( $pseudo ) > 15 )
	{
		$erreur[] = 2;
	}
	//Verification mot de pass
	if( strlen( $pass ) > 20 )
	{
		$erreur[] = 3;
	}
	if( $pass != $passconf )
	{
		$erreur[] = 4;
	}
	//Verification email
	if( !preg_match( '#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#is', $email ) )
	{
		$erreur[] = 5;
	}
	$resultmail = mysql_query( 'SELECT COUNT(*) AS nbr FROM coordonees WHERE email = \'' . $email . '\'' )
	 or exit( 'Erreur MySQL: ' . mysql_error() . '<br />' . __LINE__ );
	$donneesmail = mysql_fetch_array($resultmail);
	$nombremail = $donneesmail['nbr'];
	if( $nombremail > 0 )
	{
		$erreur[] = 9;
	}
	if( strlen($email) > 40 )
	{
		$erreur[] = 6;
	}
	//Verification date
	if( strlen( $date ) > 10 )
	{
		$erreur[] = 7;
	}
	if( !preg_match('#^[0-9]{2}/[0-9]{2}/[0-9]{4}$#is', $date ) ) 
	{
		$erreur[] = 8;
	}
	//Verification captcha
	if( !isset($_POST['secure']) || $_SESSION['securecode'] != $_POST['secure'] )
	{
		$erreur[] = 'c'.$_SESSION['securecode'];
	}
	//Validation
	if( $erreur == array() )
	{
		include( 'haut' . PHP_EXT );
		$pass = md5( $pass );
		mysql_query( 'INSERT INTO coordonees(`id`,`pseudo`,`mot de pass`,`email`,`date`,`banni`)
		 VALUES(\'\',\'' . $pseudo . '\',\'' . $pass . '\', \'' . $email . '\', \'' . $date . '\', \'' . 0 . '\')');
		 or die('Erreur MySQL: '.mysql_error().'<br />'.__LINE__);
		echo '<center>Inscription réussi !</center>';
		require_once 'bas' . PHP_EXT;
	}
	else
	{
		header( 'Location: ' . ROOT_URL . '/?inscription?pseudo=' . $pseudo . '&pass=' . $pass . '&mail=' . $email . '&date=' . $date );
		$_SESSION['erreur'] = $erreur;
//		'&erreur=' . $erreur );
	}
	require_once 'bas' . PHP_EXT;