<?php
defined( 'PHP_EXT' ) || exit();
if( isset( $_SESSION['erreurprof'] ) )
{
	echo '<b>Des erreurs sont survenues</b><ul>';
	if (in_array( 1, $_SESSION['erreurprof'] ))
	{
		echo '<li>Le pseudo est d�j� pris</li>';
	}
	if (in_array( 2, $_SESSION['erreurprof'] ))
	{
		echo '<li>Le pseudo doit faire moins de 15 caract�res.</li>';
	}
	if (in_array( 3, $_SESSION['erreurprof'] ))
	{
		echo '<li>Le mot de pass doit faire moins de 15 caract�res.</li>';
	}
	if (in_array( 4, $_SESSION['erreurprof'] ))
	{
		echo '<li>Les mots de pass ne correspondent pas.</li>';
	}
	if (in_array( 5, $_SESSION['erreurprof'] ))
	{
		echo '<li>Le format de l\'addresse email est incorrecte</li>';
	}
	if (in_array( 6, $_SESSION['erreurprof'] ))
	{
		echo '<li>L\'adresse email doit faire moins de 40 caract�res.</li>';
	}
	if (in_array( 9, $_SESSION['erreurprof'] ))
	{
		echo '<li>L\'email est d�j� utilis�e</li>';
	}
	if (in_array( 'c', $_SESSION['erreurprof'] ))
	{
	}
	echo '</ul>';
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
	echo '<span class="erreur">Vous n\'�tes pas identifi�.</span>';
}