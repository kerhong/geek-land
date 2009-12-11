<?php
defined( 'PHP_EXT' ) || exit('');
if( isset( $_SESSION['erreurprof'] ) )
{
	foreach( $_SESSION['erreurprof'] as $erreur )
	{
		switch( $erreur )
		{
			case 1:
				echo '<li>Le pseudo est déjà pris</li>';
				break;
			case 2:
				echo '<li>Le pseudo doit faire moins de 15 caractères.</li>';
				break;
			case 3:
				echo '<li>Le mot de pass doit faire moins de 15 caractères.</li>';
				break;
			case 4:
				echo '<li>Les mots de pass ne correspondent pas.</li>';
				break;
			case 5:
				echo '<li>Le format de l\'addresse email est incorrecte</li>';
				break;;
			case 6:
				echo '<li>L\'adresse email doit faire moins de 40 caractères.</li>';
				break;
			case 9:
				echo '<li>L\'email est déjà utilisée</li>';
				break;
		}
	}
}
if (isset($_SESSION['id'])) {
	$form_profil = new Form( array( 'action' => 'index.php?page=modification' ) );
	
	$form_profil->input( array(
		'name' => 'pseudo',
		'value' => $_SESSION['pseudo']
	), NULL )
		->label( 'Votre pseudo :', array( 'class' => 'form_align' ) ) . '<br />';
	
	$form_profil->input( array(
		'name' => 'mail',
		'value' => $_SESSION['mail']
	), NULL )
		->label( 'Votre email :', array( 'class' => 'form_align' ) ) . '<br />';
	
	$form_profil->input( array(
		'name' => 'pass'
	), 'password' )
		->label( 'Votre mot de pass (Pas obligatoire):', array( 'class' => 'form_align' ) ) . '<br />';
		
	$form_profil->input( array(
		'name' => 'passconf'
	), 'password' )
		->label( 'Confirmation :', array( 'class' => 'form_align' ) ) . '<br />';
		
	$form_profil->input( NULL, 'submit' );
	echo $form_profil;
}
else {
	echo '<span class="erreur">Vous n\'êtes pas identifié.</span>';
}