<?php
ob_start();
try
{
	define( 'BLOCK', 0 );
	define( 'PHP_EXT', strrchr( __FILE__, '.' ) );
	require_once 'lib/fonctions' . PHP_EXT;
	( BLOCK != 1 ) || exit( 'Page bloqu�e.' );
	$view = View::getInstance();
	$view->fullPage();
}
catch( InputException $e )
{
	exit( 'Erreur lors de la g�n�ration des formulaires: ' . $e->getMessage() );
}
catch( BddException $e)
{
	exit( 'Erreur dans la base de donn�es: ' . $e->getMessage() );
}
catch( Exception $e )
{
	exit( 'Erreur de type inconnue: ' . $e->getMessage() );
}
echo $view->parse( substr( ob_get_flush(), 0, -1 ) );
exit();