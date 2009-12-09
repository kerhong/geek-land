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
			<div class="bloc"><!--Les fameux blocs ^^-->
				<h3>
					Connexion
				</h3>
				<?php 
				if (!isset($_SESSION['id'])) {
				$form = new Form( array( 'action' => '?page=connexion' ) );
				$form->input( array( 'name' => 'pseudo', 'value' => 'Pseudo' ) )
						->label( 'Pseudo' )
						->margin( true ). '<br />';
				$form->input( array( 'name' => 'pass' ), 'password' )
						->label( 'Mot de passe' )
						->margin( true ). '<br />';
				$form->input( NULL, 'submit' )
						->margin( true );
				echo $form;
				?><br />
				<script type="text/javascript">
					getElementByName('pseudo').onClick = function() {
						this.value = '';
					}
				</script>
				<a href="?page=inscription">Inscription</a>
				<?php
				}
				else {
				echo 'Vous êtes connecté';
				}
				?>
			</div>
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