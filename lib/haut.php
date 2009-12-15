<?php defined( 'PHP_EXT' ) || exit();
include_once 'lib/fonctions' . PHP_EXT; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
	<head>
		<title>
			.:: GeeK-LanD &bull; <?php out('page'); ?> ::.
		</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link rel="stylesheet" media="screen" type="text/css" title="Design" href="geek-3.css" />
		<?php require_js( 'http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js', 'fonctions' ); ?>
		<script type="text/javascript">
			a(function ($)
			{
				$( '._hide_me' ).hide();
			} );
		</script>
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
					echo '<img src="connection.png"><span class="MiseEnValeur">Connexion</span>';
					$form = new Form( array( 'action' => '?page=connexion', 'onsubmit' => 'connection(); return false;' ) );
					$form->input( array(
							'name' => 'pseudo',
							'id' => 'pseudo',
							'value' => 'Pseudo',
							'onclick' => 'if (this.value == \'Pseudo\') this.value = \'\';',
						) )
							->margin( true )
							->label( 'Pseudo' );
					$form->input( array(
							'name' => 'pass',
							'id' => 'pass',
							'onclick' => 'if (this.value == \'*******\') this.value = \'\';'
						), 'password' )
							->margin( true )
							->label( 'Mot de passe' );
					$form->input( array(
							'value' => 'Se connecter !',
						), 'submit' )
							->margin( true );
					echo $form;
					anchor( 'inscription' );
					?>
					<script type="text/javascript">
						var xhr_active_request,
							elem_pseudo = jQuery( '#pseudo' ),
							elem_pass = jQuery( '#pass' ),
							elem_connexion = jQuery( '#connexion' );
						function connection()
						{
							var pseudo = toURI( elem_pseudo );
							var pass = toURI( elem_pass );
							if( pass == '' || pseudo == '' )
							{
								elem_connexion.html( '<p align="center" class="error">Vous devez donner un pseudo et un mot de passe</p>' + elem_connexion.html() );
								return false;
							}
							elem_connexion.html( 'Initialisation de la connexion ...' );
							jQuery.ajax(
							{
								'type': 'POST',
								'url': 'pages/ajax/connexion.php',
								'data': { 'pseudo': pseudo, 'pass': pass },
								'beforeSend': function(xhr)
								{
									elem_connexion.html( '<center>Connexion en cours ...<br /><img src="loader.gif"></center>' );
									xhr_active_request++;
								},
								'complete': function(xhr, text)
								{
									xhr_active_request--;
								},
								'error': function(xhr, text, info)
								{
									elem_connexion.html( 'Erreur pendant la requête, message: ' + info + ' - Données reçues: ' + text );
								},
								'success': function(data, text)
								{
									elem_connexion.html( data );
								}
							} );
						}
					</script>
						<?php
					}
					else
					{
						?>
						<br /><img src="<?php echo $_SESSION['avatar']; ?>"> <br />Bienvenue, <?php echo $_SESSION['pseudo']; ?><br />
						<li><?php anchor( 'deconnexion', 'Déconnexion' ); ?></li>
						<li><?php anchor( 'profil', 'Profil' ); ?></li>
						<?php
					}
					?>
				</span>
			</div>
			<div class="bloc"><!--Le menu-->
				<img src="navigation.png"><span class="MiseEnValeur">
					Menu
				</span>
				<ul>
					<li>
						<?php anchor( 'index', 'Acceuil' ); ?>
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