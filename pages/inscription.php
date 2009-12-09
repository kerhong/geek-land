<?php 
	$cryptinstall="./lib/cryptographp.fct.php";
	include $cryptinstall;  
	defined( 'PHP_EXT' ) || exit();
	if (isset($_SESSION['erreur']))
	{
		$erreur = $_SESSION['erreur'];
//		if( in_array( 1, $_SESSION['erreur'] ) )
//		echo '<li>' . implode('</li><li>', $_SESSION['erreur']) . '</li>';
		foreach ($erreur as $erreur) {
			if (preg_match('#1#',$erreur))
				echo '<li>Le pseudo est d�j� pris</li>';
			if (preg_match('#2#',$erreur))
				echo '<li>Le pseudo doit faire moins de 15 caract�res.</li>';
			if (preg_match('#3#',$erreur))
				echo '<li>Le mot de pass doit faire moins de 15 caract�res.</li>';
			if (preg_match('#4#',$erreur))
				echo '<li>Les mots de pass ne correspondent pas.</li>';
			if (preg_match('#5#',$erreur))
				echo '<li>Le format de l\'addresse email est incorrecte</li>';
			if (preg_match('#6#',$erreur))
				echo '<li>L\'adresse email doit faire moins de 40 caract�res.</li>';
			if (preg_match('#7#',$erreur))
				echo '<li>La date est trop longue.</li>';
			if (preg_match('#8#',$erreur))
				echo '<li>La date n\'est pas au bon format.</li>';
			if (preg_match('#9#',$erreur))	
				echo '<li>L\'email est d�j� utilis�e</li>';
			if (preg_match('#c#',$erreur))	
				echo '<li>Le captcha n\'est pas bon';
		}
	}
?>
	<p>Inscription :</p>
<?php
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
				->label( 'Veillez rentrer les caract&egrave;res de l\'image :<br /><img src="securite.php" alt="Code de s�curit�" />',
					array( 'class' => 'form_align' ) ) . '<br />';
	$form_insc->input( NULL, 'submit' );
	echo $form_insc;