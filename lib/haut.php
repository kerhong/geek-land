<?php defined( 'PHP_EXT' ) || exit();
include_once 'lib/fonctions' . PHP_EXT; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
	<head>
		<title>
			.:: GeeK-LanD &bull; {page} ::.
		</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link rel="stylesheet" media="screen" type="text/css" title="Design" href="geek-3.css" />
	</head>
	<body>
		<div id="en_tete"><!--Header basique ...-->
			<h1>
				GeeK-LanD
			</h1>
			<p style="font-size: 12px; font-family: verdana;">
				<em>
					Le site communautaire de tous les GeeKs
				</em>
			</p>
		</div>
		<!--La colonne du menu.-->
		<div id="colonne">
			<span id="connexion">
			<div class="bloc"><!--Les fameux blocs ^^-->
				<h3>
					Connexion
				</h3>
				<?php 
				if( !isset($_SESSION['id'] ) )
				{
					$form = new Form( array( 'action' => '?page=connexion' ) );
					$form->input( array(
							'name' => 'pseudo',
							'id' => 'pseudo',
							'value' => 'Pseudo',
							'onclick' => 'this.value = \'\';',
						) )
							->label( 'Pseudo' )
							->margin( true ). '<br />';
					$form->input( array(
							'name' => 'pass',
							'id' => 'pass'
						), 'password' )
							->label( 'Mot de passe' )
							->margin( true ). '<br />';
					$form->input(array(
							//'onclick' => 'connection();',
							//'value' => 'Envoyer !'
							)
							//, 'button' )
							, 'submit' )
							->margin( true );
					echo $form;
					?><br />
					<a href="?page=inscription">Inscription</a>
				<script type="text/javascript">
					function connection() {
					alert('Connection');
					var xhr = initxhr();
					document.getElementById("connexion").innerHTML="Initialisation...";
					xhr.open("POST","pages/connexionajax.php",true);
					xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
					var pseudo = document.connexion.getElementById('pseudo').value;
					alert(pseudo);
					var pass = encodeURIComponent(document.getElementById('pass').value);
					alert(pseudo+pass);
					xhr.send("pseudo="+pseudo+"&pass="+pass);
					xhr.onreadystatechange = function() {
						if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
							document.getElementById("connexion").innerHTML=xhr.responseText; 
						}
						if (xhr.readyState == 2) {
							document.getElementById("connexion").innerHTML='Connection en cours...';
						}
						if (xhr.readyState == 3) {
							document.getElementById("connexion").innerHTML='Connécté...';
						}
					};
					};
					function initxhr() {
						var xhr = null;
						if (window.XMLHttpRequest || window.ActiveXObject) {
							if (window.ActiveXObject) {
								try {
									xhr = new ActiveXObject("Msxml2.XMLHTTP");
								} catch(e) {
									xhr = new ActiveXObject("Microsoft.XMLHTTP");
								}
							} else {
								xhr = new XMLHttpRequest(); 
							}
						} else {
							alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
							return null;
						}
						return xhr;
					}
				</script>
				
					<?php
				}
				else
				{
					echo 'Vous &ecirc;tes bien connécté.<br /><img src="no-avatar.gif"><a href="?page=deconnexion">Déconnexion</a>';
				}
				?>
			</div>
			</span>
			<div class="bloc"><!--Le menu-->
				<h3 align="center">
					Menu
				</h3>
				<ul>
					<li>
						<a href="?">Accueil</a>
					</li>
					<li>
						<a href="#">Forum</a>
					</li>
					<li>
						<a href="#">Tutoriaux</a>
					</li>
					<li>
						<a href="#">News</a>
					</li>
					<li>
						<a href="#">Contact</a>
					</li>
				</ul>
			</div>
		</div>