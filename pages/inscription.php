<?php
	defined( 'PHP_EXT' ) || exit();
	require_once 'crypt/cryptographp.fct' . PHP_EXT;
if( isset( $_SESSION['erreur'] ) )
{
	echo '<b>Des erreurs sont survenues</b><ul>';
	if (in_array( 1, $_SESSION['erreur'] ))
	{
		echo '<li>Le pseudo est déjà pris</li>';
	}
	if (in_array( 2, $_SESSION['erreur'] ))
	{
		echo '<li>Le pseudo doit faire moins de 15 caractères.</li>';
	}
	if (in_array( 3, $_SESSION['erreur'] ))
	{
		echo '<li>Le mot de pass doit faire moins de 15 caractères.</li>';
	}
	if (in_array( 4, $_SESSION['erreur'] ))
	{
		echo '<li>Les mots de pass ne correspondent pas.</li>';
	}
	if (in_array( 5, $_SESSION['erreur'] ))
	{
		echo '<li>Le format de l\'addresse email est incorrecte</li>';
	}
	if (in_array( 6, $_SESSION['erreur'] ))
	{
		echo '<li>L\'adresse email doit faire moins de 40 caractères.</li>';
	}
	if (in_array( 9, $_SESSION['erreur'] ))
	{
		echo '<li>L\'email est déjà utilisée</li>';
	}
	if (in_array( 'c', $_SESSION['erreur'] ))
	{
	}
	echo '</ul>';
}
	echo '<p>Inscription :</p>';
	$form_insc = new Form( array( 'action' => 'index.php?page=traitement&PHPSESSID=' . session_id() ) );
	$form_insc->input( array(
			'name' => 'pseudo',
			'_take_from' => 'GET',
		), NULL )
				->label( 'Votre pseudo :', array( 'class' => 'form_align' ) ) . '<br />';
	$form_insc->input( array(
			'name' => 'pass',
			'maxlength' => 20,
			'_take_from' => 'GET',
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
			'_take_from' => 'GET',
		), NULL )
				->label( 'Votre E-Mail :', array( 'class' => 'form_align' ) ) . '<br />';
	$form_insc->input( array(
			'name' => 'date',
			'maxlength' => 10,
			'_take_from' => 'GET',
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

	$form_insc->input( array(
			'name' => 'code',
			'maxlength' => 15,
		), NULL )
				->label( '<img src="pages/'.$_SESSION['cryptdir'].'/cryptographp.php?cfg=0&PHPSESSID='.session_id().'"><br />Veuillez taper les lettres de l\'image :', array( 'class' => 'form_align' ) ) . '<br />';
	

		
	$form_insc->input( NULL, 'submit' );
	echo $form_insc;