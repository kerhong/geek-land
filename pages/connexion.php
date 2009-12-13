<?php
	if( !empty( $_POST['pseudo'] ) && !empty( $_POST['pass'] ) )
	{
		$query = Doctrine_Core::getTable( T_COORD )->findOneByPseudoAndPassword($_POST['pseudo'], $_POST['pass']);
		if( $query != NULL )
		{
			$_SESSION['id'] = $resultat['id'];
			$_SESSION['pseudo'] = $resultat['pseudo'];
			$_SESSION['pass'] = $resultat['mot de pass'];
			$_SESSION['mail'] = $resultat['email'];
			$_SESSION['avatar'] = 'no-avatar.gif';
			echo 'Tu est bien connecté.'; //.$_SESSION['id'];
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