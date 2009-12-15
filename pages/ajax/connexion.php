<?php
define( 'BLOCK', 0 );
define( 'PHP_EXT', strrchr( __FILE__, '.' ) );
define( 'ROOT', './../../' );
header( 'Content-Type: text/html; charset=utf-8' );
require_once ROOT . 'lib/fonctions.php';
( isAjaxRequest() ) || exit();
if( isset( $_POST['pseudo'] ) && isset( $_POST['pass'] ) )
{
	$resultat = Doctrine_Core::getTable( T_COORD )->findOneByPseudoAndPass( $_POST['pseudo'], md5( $_POST['pass'] ) );
	if( $resultat != NULL )
	{
		$_SESSION = $resultat->toArray( false );
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