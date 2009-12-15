<?php
ob_start();
try
{
	if( !isset( $_SESSION ) )
	{
		$_SESSION = array();
	}
	define( 'BLOCK', 0 );
	define( 'ROOT', './' );
	define( 'PHP_EXT', strrchr( __FILE__, '.' ) );
	require_once 'lib/fonctions' . PHP_EXT;
	( BLOCK != 1 ) || exit( 'Page bloqu�e.' );
	$view = new View();
	$view->helper( ':all' );
	$view->fullPage(); 
}
catch( Exception_Form $e )
{
	exit( 'Erreur lors de la g�n�ration des formulaires: ' . $e->getMessage() );
}
catch( Doctrine_Exception $e )
{
	exit( 'Erreur dans la base de donn�es(Doctrine): ' . $e->getMessage() );
}
catch( PDOException $e )
{
	exit( 'Erreur dans la base de donn�es(PDO): ' . $e->getMessage() );
}
catch( Exception $e )
{
	exit( 'Erreur de type inconnue: ' . $e->getMessage() );
}
echo ob_get_contents();
ob_end_flush();
exit();