<?php
session_start();
ob_start();
try
{
	define( 'BLOCK', 0 );
	define( 'PHP_EXT', strrchr( __FILE__, '.' ) );
	require_once 'lib/fonctions' . PHP_EXT;
	if( BLOCK == 1 )
	{
		exit( 'Page bloquée.' );
	}
	$view = View::getInstance();
	$view->fullPage();
}
catch( InputException $e )
{
	exit( 'Erreur lors de la génération des formulaires: ' .$e->getMessage() );
}
catch( Exception $e )
{
	exit( 'Erreur de type inconnue: ' . $e->getMessage() );
}
echo str_replace( addBracket( array_keys( $this->vars ) ), array_values( $this->vars ), substr( ob_get_flush(), 0, -1 ) );
exit();