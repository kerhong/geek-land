<?php 
	define('BLOCK','0');
	if (BLOCK == 1) 
		exit('Page bloqu�e.');
	session_start();
	include('lib/haut.php'); 
	if (isset($_GET['erreur'])) {
		$erreur = $_GET['erreur'];
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
?>

<div id="corps">
	<p>Inscription :</p>
	<form action="traitement.php"  method="post">
		<p>
			<label for="pseudo">Votre pseudo :</label> <br /> <input type="text" name="pseudo" maxlength="15" value="<?php if (isset($_GET['pseudo'])) echo $_GET['pseudo']; ?>" /> <br />
			<label for="pass">Votre mot de pass :</label> <br /> <input type="password" name="pass" maxlength="20" value="<?php if (isset($_GET['pass'])) echo $_GET['pass']; ?>"/> <br />
			<label for="passconf">Veuillez retapez votre mot de pass :</label> <br /> <input type="password" name="passconf" maxlength="20" /> <br />
			<label for="email">Votre E-Mail :</label> <br /> <input type="text" name="email" maxlength="40" value="<?php if (isset($_GET['email'])) echo $_GET['email']; ?>" /> <br />
			<label for="date">Votre date de naissance : <i>(format jj/mm/aaaa)</i> </label> <br /> <input type="text" name="date" maxlength="10" value="<?php if (isset($_GET['date'])) echo $_GET['date']; ?>"/> <br />
			<br /><label for="secure">Veuillez rentrez les caracteres de l'image :</label><br />
			<img src="securite.php" alt="Code de s�curit�" /><br /><input name="secure" type="text" size="10" />
			<br /><input type="submit" value="Envoyer !" />
		<p>
	</form>
</div>
<script type="text/javascript">
document.title = "Geek-Land - Inscription";
</script>
<?php include('lib/bas.php'); ?>

