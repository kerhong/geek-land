<?php
defined( 'PHP_EXT' ) || exit();
if( isset( $_SESSION['erreurprof'] ) )
{
	echo '<b>Des erreurs sont survenues</b><ul>'
		. checkUserParams( $_SESSION['erreurprof'] )
		. '</ul>';
}
if( isset( $_SESSION['id'] ) )
{
	$form_profil = new Form( array( 'action' => 'modification' . GL_EXT, 'enctype' => 'multipart/form-data' ) );
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
		'name' => 'avatarfile'
	), 'file' )
		->label( 'Vous pouvez uploader un avatar de 120x120 et de 200ko maximum', array( 'class' => 'form_align' ) ) . '<br />';
	$form_profil->input( NULL, 'submit' );
	echo $form_profil;
}
else
{
	echo '<span class="erreur">Vous n\'êtes pas identifié.</span>';
	redirect_to( ':root_url' );
}