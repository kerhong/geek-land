<?php
	defined( 'PHP_EXT' ) || exit();
	if( isset( $_SESSION['erreur'] ) )
	{
		echo '<b>Des erreurs sont survenues</b><ul>'
			 . checkUserParams( $_SESSION['erreur'] )
			 . '</ul>';
		unset( $_SESSION['erreur'] ); //On ne garde en mémoire les erreurs qu'une seule fois ...
	}
	echo '<p>Inscription :</p>';
	$form_insc = new Form( array( 'action' => ROOT . 'index' . PHP_EXT . '?page=traitement&PHPSESSID=' . session_id() ) );
	$form_insc->input( array(
			'name' => 'pseudo',
			'_take_from' => $_GET,
		), NULL )
				->label( 'Votre pseudo :', array( 'class' => 'form_align' ) ) . '<br />';
	$form_insc->input( array(
			'name' => 'pass',
			'maxlength' => 20,
		), 'password' )
				->label( 'Votre mot de passe :', array( 'class' => 'form_align' ) ) . '<br />';
	$form_insc->input( array(
			'name' => 'passconf',
			'maxlength' => 20,
		), 'password' )
				->label( 'Veuillez retaper votre mot de passe :', array( 'class' => 'form_align' ) ) . '<br />';
	$form_insc->input( array(
			'name' => 'email',
			'maxlength' => 40,
			'_take_from' => $_GET,
		), NULL )
				->label( 'Votre E-Mail :', array( 'class' => 'form_align' ) ) . '<br />';
	$form_insc->input( array(
			'name' => 'date',
			'maxlength' => 10,
			'_take_from' => $_GET,
			'_add_HTML' => array( 'before' => '<br />' ),
		), NULL )
				->label( 'Votre date de naissance,<br /><i>(format jj/mm/aaaa)</i> :', array( 'class' => 'form_align' ) ) . '<br />';
	$form_insc->input( array(
			'name' => 'secure',
			'class' => '_hide_me',
			'size' => 10,
		), 'password' )
				->label( 'Veuillez laisser ce champ vide :',
					array( 'class' => 'form_align _hide_me' ) ) . '<br />';
	$form_insc->input( NULL, 'submit' );
	echo $form_insc;