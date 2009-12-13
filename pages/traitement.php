<?php
	defined( 'PHP_EXT' ) || exit();
	require_once 'crypt/cryptographp.fct.php';
	if( isset( $_POST['pseudo'] ) && isset( $_POST['pass'] ) && isset( $_POST['passconf'] ) && isset( $_POST['date'] ) )
	{
		$erreur = array();
		//verification pseudo
		$result = Doctrine_Core::getTable( T_COORD )->findOneByPseudo( $_POST['pseudo'] );
		if( $result != NULL )
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
		$result = Doctrine::getTable( T_COORD )->findOnyByEmail( $_POST['email'] );
		if( $result != NULL )
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
		//verification captcha
		if( !chk_crypt( $_POST['code'] ) )
		{
			$erreur[] = 'c';
		}
		//Validation
		if( $erreur == array() )
		{
			$pass = md5( $pass );
			$coord = new User();
			$coord->pseudo = $_POST['pseudo'];
			$coord->pass = $_POST['pass'];
			$coord->mail = $_POST['mail'];
			$coord->date_birth = $_POST['date_birth'];
			$coord->date_insc = $_POST['date_insc'];
			$coord->level = 0;
//			$coord->date = new Doctrine_Expression( 'NOW()' ); //PreInsert, dans model
			echo '<center>Inscription r&eacute;ussie !</center>';
		}
		else
		{
			header( 'Location: ' . ROOT . 'index' . PHP_EXT . '?page=inscription&pseudo=' . $pseudo . '&pass=' . $pass . '&mail=' . $email . '&date=' . $date );
			$_SESSION['erreur'] = $erreur;
		}
	}
	else
	{
		echo '
		<h1>
			Vous devez remplir les champs obligatoire
		</h1>';
		header( 'Location: ' . ROOT . 'index' . PHP_EXT . '?page=inscription&pseudo=' . $pseudo . '&pass=' . $pass . '&mail=' . $email . '&date=' . $date );
	}