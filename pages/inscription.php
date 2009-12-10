<?php
	defined( 'PHP_EXT' ) || exit();
	if( isset( $_SESSION['erreur'] ) )
	{
		foreach( $_SESSION['erreur'] as $erreur )
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
				case 7:
					echo '<li>La date est trop longue.</li>';
					break;
				case 8:
					echo '<li>La date n\'est pas au bon format.</li>';
					break;
				case 9:
					echo '<li>L\'email est déjà utilisée</li>';
					break;
				case 'c':
					echo '<li>Le captcha n\'est pas bon';
					break;
			}
		}
	}
echo '<p>Inscription :</p>';
	$form_insc = new Form( array( 'form' => 'index.php?page=traitement' . PHP_EXT ) );
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
				->label( 'Votre date de naissance <i>(format jj/mm/aaaa)</i> :', array( 'class' => 'form_align' ) ) . '<br />';
	$form_insc->input( array(
			'name' => 'secure',
			'size' => 10,
		), 'password' )
				->label( 'Veillez rentrer les caract&egrave;res de l\'image :<br /><img src="securite.php" alt="Code de sécurité" />',
					array( 'class' => 'form_align' ) ) . '<br />';
	$form_insc->input( NULL, 'submit' );
	echo $form_insc;