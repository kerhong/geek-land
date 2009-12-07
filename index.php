<?php
try
{
	define('BLOCK','0');
	if (BLOCK == 1)
	{
		exit( 'Page bloquée.' );
	}
	session_start();
	ob_start();
	define( 'PHP_EXT', strrchr( __FILE__, '.') );
	$file_by_def = 'index';
	$page = isset( $_GET['page'] )?str_replace( '..', '', $_GET['page'] ):$file_by_def;
	$page = strtolower( $page );
	$page_ = 'pages/' . $page . PHP_EXT;
	require_once 'lib/haut' . PHP_EXT;
	?>
	<div id="corps">
	<?php
	if( !file_exists( $page_ ) )
	{
		$page = $file_by_def;
	}
	include( $page_ );
	?>
	</div>
	<?php
	require_once 'lib/bas' . PHP_EXT;
	echo ob_end_flush();
}
catch( InputException $e )
{
	exit( 'Erreur lors de la génération des formulaires: ' .$e->getMessage() );
}
catch( Exception $e )
{
	exit( 'Erreur de type inconnue: ' . $e->getMessage() );
}
exit();