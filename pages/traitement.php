<?php
	defined( 'PHP_EXT' ) || exit();
	require_once 'crypt/cryptographp.fct.php';
	if( isset( $_POST['pseudo'] ) && isset( $_POST['pass'] ) && isset( $_POST['passconf'] ) && isset( $_POST['date'] ) )
	{
		$erreur = array();
		$pseudo = Bdd::secure( $_POST['pseudo'] );
		$pass = Bdd::secure( $_POST['pass'] );
		$passconf = Bdd::secure( $_POST['passconf'] );
		$email = Bdd::secure( $_POST['email'] );
		$date = Bdd::secure( $_POST['date'] );
		//verification pseudo
		/*
		$result = Doctrine::getTable( T_COORD )->findOneByPseudo( $_POST['pseudo'] );
		if( $result != NULL )
		*/
		$result = Bdd::query( 'SELECT COUNT(*) AS nbr
			FROM ' . T_COORD . '
			WHERE pseudo = \'' . $pseudo . '\'' );
		$donnees = Bdd::fetch( 'array', $result );
		if( $donnees['nbr'] > 0 )
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
		/*
		$result = Doctrine::getTable( T_COORD )->findOnyByEmail( $_POST['email'] );
		if( $result != NULL )
		*/
		$resultmail = Bdd::query( 'SELECT COUNT(*) AS nbr
				FROM ' . T_COORD . '
				WHERE mail = \'' . $email . '\'' );
		$donneesmail = Bdd::fetch( 'array', $resultmail );
		if( $donneesmail['nbr'] > 0 )
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
			/*
			$coord = new Coordonnees();
			$coord->pseudo = $pseudo;
			$coord->mot_de_pass = $pass;
			$coord->email = $email;
//			$coord->date = new Doctrine_Expression( 'NOW()' ); //PreInsert
//			$coord->banni = 0; //Default value
			*/
			Bdd::query( 'INSERT INTO ' . T_COORD . ' (`id`,`pseudo`,`pass`,`mail`,`date_birth`,`date_insc`,`level`)
				VALUES(\'\',\'' . $pseudo . '\',\'' . $pass . '\', \'' . $email . '\', \'' . $date . '\',\'\', 0)');
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