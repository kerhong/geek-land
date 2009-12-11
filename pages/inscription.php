<?php
	defined( 'PHP_EXT' ) || exit();
 $cryptinstall="crypt/cryptographp.fct.php";
 include $cryptinstall;  
	if( isset( $_SESSION['erreur'] ) )
	{
		foreach( $_SESSION['erreur'] as $erreur )
		{
			switch( $erreur )
			{
				case 1:
					echo '<li>Le pseudo est d�j� pris</li>';
					break;
				case 2:
					echo '<li>Le pseudo doit faire moins de 15 caract�res.</li>';
					break;
				case 3:
					echo '<li>Le mot de pass doit faire moins de 15 caract�res.</li>';
					break;
				case 4:
					echo '<li>Les mots de pass ne correspondent pas.</li>';
					break;
				case 5:
					echo '<li>Le format de l\'addresse email est incorrecte</li>';
					break;;
				case 6:
					echo '<li>L\'adresse email doit faire moins de 40 caract�res.</li>';
					break;
				case 7:
					echo '<li>La date est trop longue.</li>';
					break;
				case 8:
					echo '<li>La date n\'est pas au bon format.</li>';
					break;
				case 9:
					echo '<li>L\'email est d�j� utilis�e</li>';
					break;
				case 'c':
					echo '<li>Le captcha n\'est pas bon';
					break;
			}
		}
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