<?php
	if( !empty( $_POST['pseudo'] ) && !empty( $_POST['pass'] ) )
	{
		$pass = bdd::secure( md5( $_POST['pass'] ) );
		$pseudo = bdd::secure( $_POST['pseudo'] );
		$requete = mysql_query( 'SELECT id, pseudo, `mot de pass`, email
			FROM `coordonees`
			WHERE pseudo = \'' . $pseudo . '\'
			GROUP BY id' );
		$resultat = mysql_fetch_array($requete,MYSQL_ASSOC);
		if( $pass == $resultat['mot de pass'] )
		{
			$_SESSION['id'] = $resultat['id'];
			$_SESSION['pseudo'] = $resultat['pseudo'];
			$_SESSION['pass'] = $resultat['mot de pass'];
			$_SESSION['mail'] = $resultat['email'];
			echo 'Tu est boen connect�.';
			//header( 'Location: http://geek-land.zxq.net/');
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