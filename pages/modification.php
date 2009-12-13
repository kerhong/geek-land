<?php
	defined( 'PHP_EXT' ) || exit();
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
		$pseudo = Bdd::secure( $_POST['pseudo'] );
		$pass = Bdd::secure( $pass );
		$passconf = Bdd::secure( $passconf );
		$email = Bdd::secure( $_POST['mail'] );

		$result = Bdd::query( 'SELECT COUNT(*) AS nbr
			FROM ' . T_COORD . '
			WHERE pseudo = \'' . $pseudo . '\'' );
		$donnees = Bdd::fetch( 'array', $result );
		if( $donnees['nbr'] > 0 && $_SESSION['pseudo'] != $pseudo)
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
		$resultmail = Bdd::query( 'SELECT COUNT(*) AS nbr
			FROM ' . T_COORD . '
			WHERE mail = \'' . $email . '\'' );
		$donneesmail = Bdd::fetch( 'array', $resultmail );
		if( $donneesmail['nbr'] > 0 && $_SESSION['mail'] != $email )
		{
			$erreur[] = 9;
		}
		if( isset( $email[40] ) )
		{
				$erreur[] = 6;
		}
		if (!isset($_POST['avatar'])) {
			$avatar = 'no-avatar.gif';
		}
		else {
			$avatar = Bdd::secure( $_POST['avatar']);
		}
		if( $erreur == array() )
		{
			Bdd::query( 'UPDATE ' . T_COORD . '
				SET pseudo=\'' . $pseudo . '\',
					mail=\'' . $email . '\',           
					`pass`=\'' . $pass . '\',
					avatar=\''. $avatar .'\'
				WHERE pseudo=\'' . str_replace(' ','_', $_SESSION['pseudo'] ) . '\'');
			$_SESSION = array(
					'pseudo' => $pseudo,
					'pass' => $pass,
					'mail' => $email,
					'avatar' => $avatar,
				);
			echo 'Vos informations ont bien été modifiées.';
		}
		else
		{
			$_SESSION['erreurprof'] = $erreur;
			header('Location: ' . ROOT . 'index' . PHP_EXT . '?page=profil');
		}
	}