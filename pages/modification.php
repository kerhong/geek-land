<?php
	defined( 'PHP_EXT' ) || exit();
	function quitter() {
		$_SESSION['erreurprof'] = $erreur;
		header('Location: ' . ROOT . 'profil' . GL_EXT );
		die();
	}
	if( !isset( $_POST['pass'] ) && !isset( $_POST['passconf'] ) )
	{
		$pass = $_SESSION['pass'];
		$passconf = $_SESSION['pass'];
	}
	else
	{
		$pass = isset( $_POST['pass'] ) ? md5( $_POST['pass'] ) : '';
		$passconf = isset( $_POST['passconf'] ) ? md5( $_POST['passconf'] ) : '';
	}
	if( isset( $_POST['pseudo'] ) && isset( $_POST['mail'] ) )
	{
		$erreur = array();

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
		if( isset($_POST['pass']) && isset( $_POST['pass'][20] ) )
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
			$avatar = 'no-avatar.gif';
		}
		else
		{
			$avatar = $_FILES['avatarfile'];
			if ($avatar['error'] == UPLOAD_ERR_NO_FILE) $erreur[] = 15; quitter();
			if ($avatar['error'] == UPLOAD_ERR_PARTIAL) $erreur[] = 16; quitter();
			$nom = $avatar['name'];
			$type = $avatar['type'];
			$chemin = $avatar['tmp_name'];
			$typeautorise = array( 'jpg', 'gif', 'png', 'jpeg');
			$extension = explode('.', $nom);
			$extension = end($extension);
			$poids = $avatar['size'];
			$poidsmax = 200;
			$tailles = getimagesize($chemin);
			$hauteur = $tailles[1];
			$largeur = $tailles[0];
			$hauteurmax = 120;
			$largeurmax = 120;
			if ($hauteur > $hauteurmax || $largeur > $largeurmax) $erreur[] = 14; quitter();
			if ($poids > $poidsmax) $erreur[] = 12; quitter();
			if (!in_array($extension, $typeautorise)) $erreur[] = 13; quitter();
			move_uploaded_file($chemin, ROOT . '/avatar/' . $nom);
		}
		if( $erreur == array() )
		{
			$user = Doctrine_Core::getTable( T_COORD )->findOneByPseudo( str_replace(' ','_', $_SESSION['pseudo'] ) );
			if( $user != NULL )
			{
				$user->pseudo = $_POST['pseudo'];
				$user->mail = $_POST['mail'];
				$user->pass = $pass;
				$user->avatar = $avatar;
				$user->save();
				$_SESSION = $user->toArray( false ); //False: ne pas inclure les relations ;)
				echo 'Vos informations ont bien été modifiées.';
			}
			else
			{
				echo 'Erreur';
			}
		}
		else
		{
			$_SESSION['erreurprof'] = $erreur;
			header('Location: ' . ROOT . 'profil' . GL_EXT );
		}
	}