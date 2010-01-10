<?php defined( 'PHP_EXT' ) || exit();
	$type_getter = 'p_id';
	$page_actuelle = isset( $_GET[$type_getter] )?intval( $_GET[$type_getter] ):1;
	$par_page = 2;
	$query = Doctrine_Query::create()
							->from( T_NEWS );
	$pagination = new Doctrine_Pager( $requete, $page_actuelle, $par_page );
	$news = $query->execute( array(), Doctrine::HYDRATE_ARRAY );
	if( $news == NULL )
	{
		echo 'Aucune news';
		$view->skip_rest_of_page();
	}
	foreach( $news as $new )
	{
		echo '
<h1>
	' . $new['title'] . '
</h1>
<em style="font-size: 10px;">
	Ajouté le: ' . $new['created_at'] . '&nbsp;' . ( ( $new['created_at'] == $new['updated_at'] )?'&nbsp;&bull;Dernière modification: ':$new['updated_at'] ) .
 ( !check_auth( $_SESSION, LEVEL_ADMINISTRATOR )?'':'<br /><br />'
	. anchor( 'admin_news', '&Eacute;diter cette news', array( '_get' => array( 'mode' => 'edit', 'id' => $new['id'], ) ), true ) ) . '&nbsp;&bull;&nbsp;'
	. anchor( 'admin_news', 'Supprimer cette news', array( '_get' => array( 'mode' => 'delete', 'id' => $new['id'], ) ), true ) . '
</em>
<p align="center">
	' . $new['body'] . '
</p>';
	} 
	if( check_auth( $_SESSION, LEVEL_ADMINISTRATOR ) )
	{
		echo '<br /><br />' . anchor( 'admin_news', 'Ajouter une news', array( '_get' => array( 'mode' => 'add', ) ), true );
	}
	$affichage = new Doctrine_Pager_Layout( $pagination, new Doctrine_Pager_Range_Jumping( array( 'chunk' => 4 ) ), '?' . $type_getter . '={%page_number}' );
	$affichage->setTemplate( '[<a href="{%url}">{%page}</a>]' );
	$affichage->setSelectedTemplate( '[<b>{%page}</b>]' );