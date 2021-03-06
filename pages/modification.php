<?php
	defined( 'PHP_EXT' ) || exit();
	define('GL_EXT', '.geek-land');
	function quitter($erreur)
	{
		global $erreur;
		$_SESSION['erreurprof'] = $erreur;
		header( 'Location: ' . ROOT . 'profil' . GL_EXT );
	} 
	if( empty( $_POST['pass'] ) && empty( $_POST['passconf'] ) )
	{
		$pass = $_SESSION['pass'];
		$passconf = $_SESSION['pass'];
	}
	else
	{
		$pass = !empty( $_POST['pass'] ) ? md5( $_POST['pass'] ) : '';
		$passconf = !empty( $_POST['passconf'] ) ? md5( $_POST['passconf'] ) : '';
	}
	if( !empty( $_POST['pseudo'] ) && !empty( $_POST['mail'] ) )
	{
		$erreur = array();
		$pseudo = $_POST['pseudo'];
		$email = $_POST['mail'];
		$count_pseudo = Doctrine_Core::getTable( T_COORD )->findOneByPseudo( $_POST['pseudo'] );
		if( $count_pseudo != NULL && $_SESSION['pseudo'] != $pseudo )
		{
			$erreur[] = 1;
		}
		if( strlen( $pseudo ) > 15 )
		{
			$erreur[] = 2;
		}
		//Verification mot de pass
		if( !empty($_POST['pass']) && isset( $_POST['pass'][15] ) )
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
		$count_mail = Doctrine_Core::getTable( T_COORD )->findOneByMail( $_POST['mail'] );
		if( $count_mail != NULL && $_SESSION['mail'] != $email )
		{
			$erreur[] = 9;
		}
		if( isset( $email[40] ) )
		{
			$erreur[] = 6;
		}
		if( !isset( $_FILES['avatarfile'] ) )
		{
			$nom = $_SESSION['avatar'];
		}
		else
		{
			$avatar = $_FILES['avatarfile'];
			$nom = $avatar['name'];
			$type = $avatar['type'];
			$typeautorise = array( 'image/gif', 'image/jpeg', 'image/png');
			$chemin = $avatar['tmp_name'];
			$extensionautorise = array( 'jpg', 'gif', 'png', 'jpeg' );
			$extension = explode( '.', $nom );
			$extension = end( $extension );
			$poids = $avatar['size'];
			$poidsmax = 20000;
			$tailles = getimagesize( $chemin );
			$hauteur = $tailles[1];
			$largeur = $tailles[0];
			$hauteurmax = 120;
			$largeurmax = 120;
			$mime = $chemin['mime'];
			if ( $poids > $poidsmax )
			{
				$erreur[] = 12;
				quitter();
				
			}
			if( !in_array( strtolower($extension), $extensionautorise ) )
			{			
				$erreur[] = 13;
				quitter();
			}
			if (!in_array($type, $typeautorise) ) {
				$erreur[] = 13;
				quitter();
			}
			/*if (!in_array($mime, $typeautorise) ) {
				$erreur[] = 13;
				quitter();
			}*/
			if( $hauteur > $hauteurmax || $largeur > $largeurmax )
			{
				$erreur[] = 14;
				quitter();
			}
			if( $avatar['error'] == UPLOAD_ERR_NO_FILE )
			{
			
				$erreur[] = 15;
				quitter();
			}
			if( $avatar['error'] == UPLOAD_ERR_PARTIAL )
			{
				$erreur[] = 16;
				quitter();
			}
			if (file_exists( '/home/geekland/public_html/avatar/' . $_SESSION['avatar'] )) unlink( '/home/geekland/public_html/avatar/' . $_SESSION['avatar'] );
			$n = 0;
			while ( file_exists( '/home/geekland/public_html/avatar/' . $nom) ) {
				$n++;
				$nom = $n . '-' .  $avatar['name'];
			}
			$nom = str_replace('/', '-', $nom);
			if( is_uploaded_file( $avatar['tmp_name'] ) )
			{
				move_uploaded_file( $avatar['tmp_name'], '/home/geekland/public_html/avatar/' . $nom );
			}
		}
		if( $erreur == array() )
		{
			$user = Doctrine_Core::getTable( T_COORD )->findOneByPseudo( str_replace(' ','_', $_SESSION['pseudo'] ) );
			if( $user != NULL )
			{
				$user->pseudo = $_POST['pseudo'];
				$user->mail = $_POST['mail'];
				$user->pass = $pass;
				$user->avatar = $nom;
				$user->save();
				$_SESSION = $user->toArray( false ); //False: ne pas inclure les relations ;)
				echo 'Vos informations ont bien �t� modifi�es.';
			}
			else
			{
				$_SESSION['erreurprof'] = $erreur;
				header('Location: ' . ROOT . 'profil' . GL_EXT );
			}
		}
		else
		{
			$_SESSION['erreurprof'] = $erreur;
			header('Location: ' . ROOT . 'profil' . GL_EXT );
		}
	}