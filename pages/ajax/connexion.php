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
	$requete = bdd::query( 'SELECT id, pseudo, `pass`, mail, date_insc, date_birth, avatar, level
		FROM ' . T_COORD . '
		WHERE pseudo = \'' . $pseudo . '\'
			GROUP BY id' );
	$resultat = bdd::fetch( 'array', $requete, MYSQL_ASSOC );
	if( $pass == $resultat['pass'] )
	{
		$_SESSION['id'] = $resultat['id'];
		$_SESSION['pseudo'] = $resultat['pseudo'];
		$_SESSION['pass'] = $resultat['pass'];
		$_SESSION['mail'] = $resultat['mail'];
		$_SESSION['avatar'] = $resultat['avatar'];
		$_SESSION['date_insc'] = $resultat['date_insc'];
		$_SESSION['date_birth'] = $resultat['date_birth'];
		$_SESSION['level'] = $resultat['level'];
		echo '<br /><img src="' . $_SESSION['avatar'] . '"> <br />Bienvenue, ' . $_SESSION['pseudo'] . '<br />
					<li><a href="?page=deconnexion">Déconnexion</a></li>
					<li><a href="?page=profil">Profil</a></li>';
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