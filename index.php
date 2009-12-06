<?php
define( 'PHP_EXT', strrchr( __FILE__, '.') );
$file_by_def = 'index';
$page = isset( $_GET['page'] )?$_GET['page']:$file_by_def;
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