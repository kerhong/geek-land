<?php //Le niveau admin est pré-vérifié ;)
	function does_not_exists($perso_msg = NULL)
	{
		echo ( $perso_msg == NULL )?'Cette news n\'existe pas':$perso_msg;
		$view->skip_rest_of_page();
	}
	validates_get_fields( 'mode', 'id' );
	$mode = $_GET['mode'];
	$article = NULL;
	switch( $mode )
	{
		case 'delete':
			$article = Doctrine::getTable( T_COORD )->findOne( $_GET['id'] );
			$article->delete();
			break;
		case 'edit':
			$article = Doctrine::getTable( T_COORD )->findOne( $_GET['id'] );
			if( isset( $_POST['title'] && isset( $_POST['body'] ) && !empty( $_POST['title'] ) && !empty( $_POST['body'] ) )
			{
				$article->title = $_POST['title'];
				$article->body = $_POST['body'];
				$article->save();
			}
		case 'new':
			if( isset( $_POST['title'] && isset( $_POST['body'] ) && !empty( $_POST['title'] ) && !empty( $_POST['body'] ) )
			{
				$article = new Article();
				$article->title = $_POST['title'];
				$article->body = $_POST['body'];
				$article->save();
				does_not_exists( 'Article enregistré' );
			}
			$form = new Form( array() );
			$form->input( array(
					'name' => 'title',
					'value' => ( $article == NULL )?'':$article->title,
				), NULL );
			$form->input( array(
					'name' => 'body',
					'value' => ( $article == NULL )?'':$article->body,
				), NULL );
			$form->input( NULL, 'submit' );
			echo $form;
			break;
		default:
			does_not_exists( 'cette action n\'existe pas' );
	}