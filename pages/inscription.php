<?php 
	if (isset($_SESSION['erreur']))
	{
		$erreur = $_SESSION['erreur'];
//		if( in_array( 1, $_SESSION['erreur'] ) )
			echo '<li>Le pseudo est déjà pris</li>';
		if (preg_match('#2#',$erreur))
			echo '<li>Le pseudo doit faire moins de 15 caractères.</li>';
		if (preg_match('#3#',$erreur))
			echo '<li>Le mot de pass doit faire moins de 15 caractères.</li>';
		if (preg_match('#4#',$erreur))
			echo '<li>Les mots de pass ne correspondent pas.</li>';
		if (preg_match('#5#',$erreur))
			echo '<li>Le format de l\'addresse email est incorrecte</li>';
		if (preg_match('#6#',$erreur))
			echo '<li>L\'adresse email doit faire moins de 40 caractères.</li>';
		if (preg_match('#7#',$erreur))
			echo '<li>La date est trop longue.</li>';
		if (preg_match('#8#',$erreur))
			echo '<li>La date n\'est pas au bon format.</li>';
		if (preg_match('#9#',$erreur))	
			echo '<li>L\'email est déjà utilisée</li>';
		if (preg_match('#c#',$erreur))	
			echo '<li>Le captcha n\'est pas bon';
	}
?>
<div id="corps">
	<p>Inscription :</p>
	<?php
	$form_insc = new Form( array( 'form' => 'traitement' . PHP_EXT ) );
	$form_insc->input( array(
			'name' => 'pseudo',
			'_take_from' => 'GET',
		), NULL, 'Votre pseudo :' ) . '<br />';
	$form_insc->input( array(
			'name' => 'pass',
			'maxlength' => 20,
			'_take_from' => 'GET',
		), 'password', 'Votre mot de passe :' ) . '<br />';
	$form_insc->input( array(
			'name' => 'passconf',
			'maxlength' => 20,
		), 'password', 'Veuillez retaper votre mot de passe :' ) . '<br />';
	$form_insc->input( array(
			'name' => 'email',
			'maxlength' => 40,
			'_take_from' => 'GET',
		), NULL, 'Votre E-Mail :' ) . '<br />';
	$form_insc->input( array(
			'name' => 'date',
			'maxlength' => 10,
			'_take_from' => 'GET',
		), NULL, 'Votre date de naissance <i>(format jj/mm/aaaa)</i> :' ) . '<br />';
	$form_insc->input( array(
			'name' => 'secure',
			'size' => 10,
		), 'password', 'Veillez rentrer les caract&egrave;res de l\'image :<br /><img src="securite.php" alt="Code de sécurité" />' ) . '<br />';
	$form_insc->input( NULL, 'submit' );
	?>
</div>