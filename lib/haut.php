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
		<?php require_js( 'http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js', 'fonctions' ); ?>
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
			<span id="connexion">
				<?php 
				if( !isset($_SESSION['id'] ) )
				{
					echo '<h3>Connexion</h2>';
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
					$form->input( array(
							'onclick' => 'connection(); return false;',
							'value' => 'Envoyer !'
						), 'button' )
							//, 'submit' )
							->margin( true );
					echo $form;
					?><br />
					<a href="?page=inscription">Inscription</a>
				<script type="text/javascript">
					var xhr,
						elem_pseudo = jQuery( '#pseudo' ),
						elem_pass = jQuery( '#pass' ),
						elem_connexion = jQuery( '#connexion' );
					function connection()
					{
						var pseudo = toURI( elem_pseudo );
						var pass = toURI( elem_pass );
						elem_connexion.html( 'Initialisation de la connexion ...' );
						xhr.open( 'POST', 'pages/ajax/connexion.php',true);
						xhr.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
						xhr.send( 'pseudo=' + pseudo + '&pass=' + pass );
						xhr.onreadystatechange = function()
						{
							if( xhr.readyState == 4 && ( xhr.status == 200 || xhr.status == 0 ) )
							{
								elem_connexion.innerHTML = xhr.responseText;
							}
							if( xhr.readyState == 2 )
							{
								elem_connexion.innerHTML = 'Connexion en cours ...';
							}
							if( xhr.readyState == 3 )
							{
								elem_connexion.innerHTML = 'Verification des identifiants ...';
							}
						}
					}
				</script>
					<?php
				}
				else
				{
					echo 'Vous &ecirc;tes bien connécté.<br /><img src="no-avatar.gif"><a href="?page=deconnexion">Déconnexion</a>';
				}
				?>
			</span>
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