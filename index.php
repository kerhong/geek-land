<?php
define( 'PHP_EXT', strrchr( __FILE__, '.') );
include( 'lib/haut' . PHP_EXT );
?>
<div id="corps">
<?php
$file_by_def = 'index';
$page = isset( $_GET['page'] )?$_GET['page']:$file_by_def;
$page = strtolower( $page );
$page = 'html/' . $page;
if( !file_exists( $page . PHP_EXT ) )
{
	$page = $file_by_def;
}
include( $page . PHP_EXT );
?>
</div>
<?php
include( 'lib/bas' . PHP_EXT );