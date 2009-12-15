<?php //Le niveau admin est pré-vérifié ;)
	function does_not_exists($perso_msg = NULL)
	{
		echo ( $perso_msg == NULL )?'Cet utilisateur n\'existe pas':$perso_msg;
		$view->skip_rest_of_page();
	}
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
			validates_get_fields( 'show_banned', 'show_unactivated', 'show_guest', 'show_user', 'show_redactor', 'show_moderators' );
			$levels_possible = array();
			if( !$_GET['show_banned'] )
				$levels_possible[] = LEVEL_BANNED;
			if( !$_GET['show_unactivated'] )
				$levels_possible[] = LEVEL_UNVALIDATED;
			if( !$_GET['show_guest'] )
				$levels_possible[] = LEVEL_GUEST;
			if( !$_GET['show_user'] )
				$levels_possible[] = LEVEL_USER;
			if( !$_GET['show_redactor'] )
				$levels_possible[] = LEVEL_REDACTOR;
			if( !$_GET['show_moderator'] )
				$levels_possible[] = LEVEL_MODERATOR;
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
					<td style="width: 25%;">
						<b>
							' . $user['pseudo'] . '
						</b>
					</td>
					<td style="width: 75%;" align="center">
						' . anchor( 'admin_user', 'Modifier cet utilisateur', array( '_get' => array( 'mode' => 'edit', 'id' => $user['id'] ) ), true ) . ' &bull;
						' . ( $user['level'] == LEVEL_UNVALIDATED ) ?
							 anchor( 'admin_user', 'Valider cet utilisateur', array( '_get' => array( 'mode' => 'valid', 'id' => $user['id'] ) ), true )
							: '' . ' &bull;
						' . ( $user['level'] == LEVEL_BANNED )?:anchor( 'admin_user', 'Bannir cet utilisateur', array( '_get' => array( 'mode' => 'bann',
								'id' => $user['id'], ) ), true ) : '' . '
					</td>
				</tr>';
			}
			echo '
			</table>';
			break;
		case 'delete':
			validates_get_fields( 'id' );
			$user = Doctrine::getTable( T_COORD )->findOne( $_GET['id'] );
			( $user != NULL ) || does_not_exists();
			if( $user->level == LEVEL_BANNED )
			{
				$user->delete();
			}
			else
			{
				does_not_exists( 'L\'utilisateur ' . $user->pseudo . ' doit être bannit d\'abord' );
			}
			break;
		case 'valid':
			validates_get_fields( 'id' );
			$user = Doctrine::getTable( T_COORD )->findOne( $_GET['id'] );
			( $user != NULL ) || does_not_exists();
			if( $user->level == LEVEL_UNVALIDATED && check_auth( $_SESSION, LEVEL_ADMINISTRATOR, true ) ) //débannissement
			{
				$user->level = LEVEL_USER;
				$user->save();
			}
			else
			{
				does_not_exists( 'Impossible de valider l\'utilisateur ' . $user->pseudo );
			}
			break;
		case 'bann':
			validates_get_fields( 'id' );
			$user = Doctrine::getTable( T_COORD )->findOne( $_GET['id'] );
			( $user != NULL && $user->level != LEVEL_ADMINISTRATOR ) || does_not_exists();
			if( $user->level != LEVEL_BANNED )
			{
				$user->level = LEVEL_BANNED;
				$user->save();
			}
			else
			{
				does_not_exists( 'Impossible de bannir l\'utilisateur ' . $user->pseudo );
			}
			break;
		case 'edit':
			validates_get_fields( 'pseudo' );
			$user = Doctrine::getTable( T_COORD )->findOne( $_GET['id'] );
			( $user != NULL ) || does_not_exists();
			//Fonction show_user_editor() ?
			break;
	}
	