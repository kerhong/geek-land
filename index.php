<?php
ob_start();
try
{
	define( 'BLOCK', 0 );
	define( 'ROOT', './' );
	define( 'PHP_EXT', strrchr( __FILE__, '.' ) );
	require_once 'lib/fonctions' . PHP_EXT;
	( BLOCK != 1 ) || exit( 'Page bloquée.' );
	$view = View::getInstance();
	$view->fullPage();
}
catch( Exception_Form $e )
{
	exit( 'Erreur lors de la génération des formulaires: ' . $e->getMessage() );
}
catch( Exception_Bdd $e)
{
	exit( 'Erreur dans la base de données: ' . $e->getMessage() );
}
catch( Exception $e )
{
	exit( 'Erreur de type inconnue: ' . $e->getMessage() );
}
echo $view->parse( substr( ob_get_flush(), 0, -1 ) );
exit();