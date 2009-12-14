<?php
	defined( 'PHP_EXT' ) || exit();
	require_once( ROOT . '/lib/recaptchalib.php');
	$privatekey = "6Le_-gkAAAAAALYJtfZhppF4qtnj_aygR2havFrk";
	$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

	if( isset( $_POST['pseudo'] ) && isset( $_POST['pass'] ) && isset( $_POST['passconf'] ) && isset( $_POST['date'] ) && isset( $_POST['email'] ) && isset($_POST['recaptcha_challenge_field']) && isset($_POST['recaptcha_response_field']) )
	{
		$date = $_POST['date'];
		$email = $_POST['mail'];
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
		if( $_POST['pass'] != $_POST['passconf'] )
		{
			$erreur[] = 4;
		}
		//Verification email
		if( filter_var( $email, FILTER_VALIDATE_EMAIL ) != $email )
		{
			$erreur[] = 5;
		}
		$result = Doctrine::getTable( T_COORD )->findOneBymail( $_POST['email'] );
		if( $result != NULL )
		{
			$erreur[] = 9;
		}
		if( strlen( $email ) > 40 )
		{
			$erreur[] = 6;
		}
		//Verification date
		if( strlen( $date ) != 10 )
		{
			$erreur[] = 7;
		}
		$_date = explode( '/', $date );
		// Je sais pas où est la fonction if( !checkdate( $_date[0], $_date[1], $_date[2] ) )
		if ($_date[0] < 31 && $_date[0] > 1) {
		}
		else {
			$erreur[] = 8;
		}
		if ($_date[1] < 12 && $_date[1] > 1) {
		}
		else {
			$erreur[] = 8;
		}
		if ($_date[2] < 2010 && $_date[2] > 1960) {
		}
		else {
			$erreur[] = 8;
		}

		if (!$resp->is_valid) {
			$erreur[] = 10;
		}
		//Validation
		if( $erreur == array() )
		{
			$pass = md5( $pass );
			$coord = new User();
			$coord->pseudo = $_POST['pseudo'];
			$coord->pass = $_POST['pass'];
			$coord->mail = $email;
			$coord->date_birth = $_POST['date_birth'];
			$coord->date_insc = $_POST['date_insc'];
			$coord->level = 0;
//			$coord->date = new Doctrine_Expression( 'NOW()' ); //PreInsert, dans model
			echo '<center>Inscription r&eacute;ussie !</center>';
		}
		else
		{
			//header( 'Location: ' . ROOT . 'index' . PHP_EXT . '?page=inscription' );
			$_SESSION['erreur'] = $erreur;
			$stop = true;
		}
	}
	else
	{
		$_SESSION['erreur'] = array(11);
		$stop = true;
	}
	if( $stop )
	{
		header( 'Location: ' . ROOT
		 . '?page=inscription&pseudo=' . $_POST['pseudo'] . '&pass=' . $_POST['pass'] . '&mail=' . $_POST['email'] . '&date=' . $_POST['date'] );
	}