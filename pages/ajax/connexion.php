<?php
define( 'BLOCK', 0 );
define( 'PHP_EXT', strrchr( __FILE__, '.' ) );
define( 'ROOT', './../../' );
header( 'Content-Type: text/html; charset=utf-8' );
require_once ROOT . 'lib/fonctions.php';
( isAjaxRequest() ) || exit();
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
		echo encode( 'Tu est bien connecté.' );
	}
 	else
	{
		echo '<p class="error">' . encode( 'Erreur: le mot de passe et/ou le pseudo ne sont pas bons !' ) . '</p>';
	}
}
else
{
	echo '<p class="error">' . encode( 'Erreur: veuillez rentrez un pseudo et un mot de passe !' ) . '</p>';
}