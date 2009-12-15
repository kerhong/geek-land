<?php //Le niveau admin est pré-vérifié ;)
	validates_get_fields( 'mode' );
	if( $_GET['mode'] == NULL )
	{
		$mode = 'index';
	}
	else
	{
		$mode = $_GET['mode'];
	}
	switch( $mode )
	{
		case 'index':
			validates_get_fields( 'show_banned', 'show_unactivated', 'show_banned', 'show_admins', 'show_moderators' );
			$levels_possible = array()
			if( !$_GET['show_banned'] )
			if( !$_GET['show_unactivated'] )
				$levels_possible[] = LEVEL_UNVALIDATED;
			$users = Doctrine_Query::create()
					->from( 'User u' )
					->whereIn( 'u.level', $levels_possible )
					->execute( array(), Doctrine_Core::HYDRATE_ARRAY );
			echo '
			<table>';
			foreach( $users as $user )
			{
				echo '
				<tr>
					<td>
						' . $user['pseudo'] . '
					</td>
					<td>
						' . anchor( 'admin_user', 'Modifier cet utilisateur', array( '_get' => array( 'mode' => 'edit', 'id' => $user['id'] ) ), true ) . ' &bull;
						' . anchor( 'admin_user', 'Supprimer cet utilisateur', array( '_get' => array( 'mode' => 'delete', 'id' => $user['id'] ) ), true ) . ' &bull;
						' . ( $user['level'] == LEVEL_UNVALIDATED ) ?
							 anchor( 'admin_user', 'Valider cet utilisateur', array( '_get' => array( 'mode' => 'valid', 'id' => $user['id'] ) ), true )
							 : '' . '
						' . anchor( 'admin_user', ( ( $user['level'] == LEVEL_BANNED ) ? 'Déb':'B' ) . 'annir cet utilisateur', array( '_get' => array(
								'mode' => 'bann',
								'id' => $user['id'],
							) ), true ) . '
					</td>
				</tr>';
			}
			echo '
			</table>';
			break;
		case 'edit':
			validates_get_fields( 'pseudo' );
			$user = Doctrine::getTable( T_COORD )->findOneByPseudo( $_GET['pseudo'] );
			if( $user == NULL )
			{
				echo 'Cet utilisateur n\'existe pas';
			}
			else
			{
				$form = new Form();
				$form->input();
				$form->input();
			}
	}
	