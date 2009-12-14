<?php
	if( !empty( $_POST['pseudo'] ) && !empty( $_POST['pass'] ) )
	{
		$query = Doctrine_Core::getTable( T_COORD )->findOneByPseudoAndPassword( $_POST['pseudo'], md5( $_POST['pass'] ) );
		if( $query != NULL )
		{
			$_SESSION = $query->toArray( false );
			echo 'Tu est bien connecté.'; //L'ob_start() permet de faire un echo ;)
			header( 'Location: ' . ROOT_URL );
		}
 		else
		{
			echo '<p class="erreur">Erreur le mot de pass et/ou le pseudo ne sont pas bon</p>';
		}
	}
	else
	{
		echo '<p class="erreur">Erreur veuillez rentrez un pseudo et un mot de pass.</p>';
	}