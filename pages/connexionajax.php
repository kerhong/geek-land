<?php
define( 'BLOCK', 0 );
define( 'PHP_EXT', strrchr( __FILE__, '.' ) );
header('Content-Type: text/html; charset=utf-8');
include('../lib/class/bdd.php');
include('../lib/fonctions.php');
if( isset( $_POST['pseudo'] ) && isset( $_POST['pass'] ) )
	{
		$pass = bdd::secure( md5( $_POST['pass'] ) );
		$pseudo = bdd::secure( $_POST['pseudo'] );
		$requete = bdd::query( 'SELECT id, pseudo, `mot de pass`, email
			FROM ' . T_COORD . '
			WHERE pseudo = \'' . $pseudo . '\'
			GROUP BY id' );
		$resultat = bdd::fetch( 'array', $requete, MYSQL_ASSOC );
		if( $pass == $resultat['mot de pass'] )
		{
			$_SESSION['id'] = $resultat['id'];
			$_SESSION['pseudo'] = $resultat['pseudo'];
			$_SESSION['pass'] = $resultat['mot de pass'];
			$_SESSION['mail'] = $resultat['email'];
			echo 'Tu est bien connecté.';
		}
 		else
		{
			echo '<p class="erreur">Erreur le mot de pass et/ou le pseudo ne sont pas bon</p>';
		}
	}
	else
	{
		echo '<p class="erreur">Erreur veuillez rentrez un pseudo et un mot de pass.</p>';
	}

?>