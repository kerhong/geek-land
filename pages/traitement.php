<?php
	defined( 'PHP_EXT' ) || exit();
	if( isset( $_POST['pseudo'] ) && isset( $_POST['pass'] ) && isset( $_POST['passconf'] ) && isset( $_POST['date'] ) )
	{
        $pseudo = $_POST['pseudo'];
        $pass = $_POST['pass'];
        $passconf = $_POST['passconf'];
        $email = $_POST['email'];
        $date = $_POST['date'];
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
        $result = bdd::query('SELECT COUNT(*) AS nbr
			FROM {coord}
			WHERE pseudo = \'' . $pseudo . '\'');
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
        $resultmail = bdd::query( 'SELECT COUNT(*) AS nbr FROM {coord} WHERE email = \'' . $email . '\'' );
        $donneesmail = bdd::fetch( $resultmail, 'array' );
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
                $erreur[] = 'c';
        }
        //Validation
        if( $erreur == array() )
        {
        
                $pass = md5( $pass );
                bdd::query( 'INSERT INTO {coord}(`id`,`pseudo`,`mot de pass`,`email`,`date`,`banni`)
                 VALUES(\'\',\'' . $pseudo . '\',\'' . $pass . '\', \'' . $email . '\', \'' . $date . '\', \'' . 0 . '\')');
                echo '<center>Inscription r&eacute;ussie !</center>';
        }
        else
        {
                header( 'Location: ' . ROOT_URL . '?page=inscription&pseudo=' . $pseudo . '&pass=' . $pass . '&mail=' . $email . '&date=' . $date );
                $_SESSION['erreur'] = $erreur;
        }
	}
	else
	{
		echo '
		<h1>
			Vous devez remplir les champs obligatoire
		</h1>';
		header( 'Location: ' . ROOT_URL );
	}