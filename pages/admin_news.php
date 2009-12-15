<?php //Le niveau admin est pré-vérifié ;)
	function does_not_exists($perso_msg = NULL)
	{
		echo ( $perso_msg == NULL )?'Cette news n\'existe pas':$perso_msg;
		$view->skip_rest_of_page();
	}
	validates_get_fields( 'mode' );
	$mode = $_GET['mode'];
	switch( $mode )
	{
		case 'new':
		case 'edit':
			$form = new Form( array() );
		default:
			does_not_exists( 'cette action n\'existe pas' );
	}