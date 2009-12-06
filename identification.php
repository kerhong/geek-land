<?php
	include('lib/haut.php');
	if ((!empty($_POST['pseudo'])) && (!empty($_POST['pass']))) {
		$pass = mysql_real_escape_string(md5($_POST['pass']));
		$pseudo = mysql_real_escape_string($_POST['pseudo']);
		$requete = mysql_query("SELECT id, pseudo, `mot de pass`, email FROM coordonees WHERE pseudo = '".$pseudo."' GROUP BY id") or die('Erreur sur la requete mysql : '.mysql_error().'<br />'.__LINE__);
		$resultat = mysql_fetch_array($requete);
		if ($pass == $resultat['mot de pass']) {
			$_SESSION['id'] = $resultat['id'];
			$_SESSION['pseudo'] = $resultat['pseudo'];
			$_SESSION['pass'] = $resultat['mot de pass'];
			$_SESSION['mail'] = $resultat['email'];
			echo '<script type="text/javascript">window.location=\'/\'</script>';
		}
		else {
			echo '<p class="erreur">Erreur le mot de pass et/ou le pseudo ne sont pas bon</p>';
		}
	}
	else {
		echo '<p class="erreur">Erreur veuillez rentrez un pseudo et un mot de pass.</p>';
	}
	include('lib/bas.php');
?>