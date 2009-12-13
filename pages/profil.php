<?php
defined( 'PHP_EXT' ) || exit();
if( isset( $_SESSION['erreurprof'] ) )
{
	echo '<b>Des erreurs sont survenues</b><ul>'
		. checkUserParams( $_SESSION['erreur'] )
		. '</ul>';
}
if( isset( $_SESSION['id'] ) )
{
	$form_profil = new Form( array( 'action' => '?page=modification' ) );
	$form_profil->input( array(
		'name' => 'pseudo',
		'value' => $_SESSION['pseudo'],
		'maxlength' => '20',
	), NULL )
		->label( 'Votre pseudo :', array( 'class' => 'form_align' ) ) . '<br />';
	$form_profil->input( array(
		'name' => 'mail',
		'value' => $_SESSION['mail'],
		'maxlength' => '20',
	), NULL )
		->label( 'Votre email :', array( 'class' => 'form_align' ) ) . '<br />';
	$form_profil->input( array(
		'name' => 'pass',
		'maxlength' => '20',
	), 'password' )
		->label( 'Votre mot de passe (Non obligatoire):', array( 'class' => 'form_align' ) ) . '<br />';
	$form_profil->input( array(
		'name' => 'passconf'
	), 'password' )
		->label( 'Confirmation :', array( 'class' => 'form_align' ) ) . '<br />';
	
		$form_profil->input( array(
		'name' => 'avatar',
		'value' => $_SESSION['avatar'],
		'maxlength' => '20',
	), '' )
		->label( 'Mettez le nom de votre avatar uploader :', array( 'class' => 'form_align' ) ) . '<br />';
		
	$form_profil->input( NULL, 'submit' );
	echo $form_profil;
}
else
{
	header( 'Locaiton: ' . ROOT_URL );
	echo '<span class="erreur">Vous n\'êtes pas identifié.</span>';
}