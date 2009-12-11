<?php
defined( 'PHP_EXT' ) || exit();
if( isset( $_SESSION['erreurprof'] ) )
{
	echo '<b>Des erreurs sont survenues</b><ul>';
	in_array( 1, $_SESSION['erreurprof'] )
	{
		echo '<li>Le pseudo est déjà pris</li>';
	}
	in_array( 2, $_SESSION['erreurprof'] )
	{
		echo '<li>Le pseudo doit faire moins de 15 caractères.</li>';
	}
	in_array( 3, $_SESSION['erreurprof'] )
	{
		echo '<li>Le mot de pass doit faire moins de 15 caractères.</li>';
	}
	in_array( 4, $_SESSION['erreurprof'] )
	{
		echo '<li>Les mots de pass ne correspondent pas.</li>';
	}
	in_array( 5, $_SESSION['erreurprof'] )
	{
		echo '<li>Le format de l\'addresse email est incorrecte</li>';
	}
	in_array( 6, $_SESSION['erreurprof'] )
	{
		echo '<li>L\'adresse email doit faire moins de 40 caractères.</li>';
	}
	in_array( 9, $_SESSION['erreurprof'] )
	{
		echo '<li>L\'email est déjà utilisée</li>';
	}
	in_array( 'c', $_SESSION['erreurprof'] )
	{
	}
	echo '</ul>';
}
if( isset( $_SESSION['id'] ) )
{
	$form_profil = new Form( array( 'action' => '?page=modification' ) );
	$form_profil->input( array(
		'name' => 'pseudo',
		'_take_from' => 'SESSION',
	), NULL )
		->label( 'Votre pseudo :', array( 'class' => 'form_align' ) ) . '<br />';
	$form_profil->input( array(
		'name' => 'mail',
		'_take_from' => 'SESSION',
	), NULL )
		->label( 'Votre email :', array( 'class' => 'form_align' ) ) . '<br />';
	$form_profil->input( array(
		'name' => 'pass'
	), 'password' )
		->label( 'Votre mot de passe (Non obligatoire):', array( 'class' => 'form_align' ) ) . '<br />';
	$form_profil->input( array(
		'name' => 'passconf'
	), 'password' )
		->label( 'Confirmation :', array( 'class' => 'form_align' ) ) . '<br />';
	$form_profil->input( NULL, 'submit' );
	echo $form_profil;
}
else
{
	echo '<span class="erreur">Vous n\'êtes pas identifié.</span>';
}