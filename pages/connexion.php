<?php
	if( !empty( $_POST['pseudo'] ) && !empty( $_POST['pass'] ) )
	{
		//$query = Doctrine_Core::getTable( T_USER )->findOneByPseudoAndPass( $_POST['pseudo'], md5( $_POST['pass'] ) );
		/*Doctrine_Query::create()
								->from( T_USER )
								->where( 'pseudo = :pseudo' )
								->andWhere( 'pass = :pass' )
								->execute( array(
										':pseudo' => $_POST['pseudo'],
 										':pass' => md5( $_POST['pass] ),
									), Doctrine_Core::HYDRATE_ARRAY );*/
	//	$query = Doctrine_Core::getTable( T_USER )->findAll();//OneByPseudoAndPass( $_POST['pseudo'], md5( $_POST['pass'] ) );
		$query = Doctrine_Query::create()
								->from( T_COORD )
								->fetchArray();
		debug( $query );
		if( $query != NULL )
		{
			$_SESSION = $query->toArray( false );
			echo 'Tu est bien connecté.'; //L'ob_start() permet de faire un echo ;)
			redirect_to( ':root_url' );
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