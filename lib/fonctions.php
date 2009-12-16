<?php
defined( 'PHP_EXT' ) || exit();
define( 'GL_EXT', '.geek-land' );
define( 'ROOT_URL', 'http://geek-land.redheberg.com' );
session_start();

function inc( $class_name_ )
{
	$class_name = str_replace( array( '_', '\\', ), '/', $class_name_ );
	require_once ROOT . '/lib/class/' . $class_name . PHP_EXT;
}
define( 'T_COORD', 'User' );

spl_autoload_register( 'inc' );
inc( 'Doctrine_Core' );
spl_autoload_register( array( 'Doctrine_Core', 'autoload' ) );
/*Connexion used for test if PDO is the reason of issues ...
$cnx = mysql_connect( 'sql.redheberg.com', 'geekland_Site', 'jU95unj5dhJr' ) || exit(mysql_error());
mysql_select_db( 'geek-land_membre' ) || exit(mysql_error());
exit();*/
/*
 *	It's better to pass the PDO object for some reasons ...
 *	'mysql://geekland_Site:jU95unj5dhJr@localhost/geek-land_membres'var
*/
$pdo = new PDO('mysql:dbname=geekland_membre;host=localhost', 'geekland_root',  'g2qX3kYbLrYK' );
$manager = Doctrine_Manager::getInstance();
$connexion = Doctrine_Manager::connection( $pdo, 'DefaultConnection' );
$manager->setAttribute( Doctrine_Core::ATTR_USE_DQL_CALLBACKS, true );
Doctrine_Core::loadModels( ROOT . 'models/generated' );
Doctrine_Core::loadModels( ROOT . 'models/' );

define( 'LEVEL_BANNED', -2 );
define( 'LEVEL_UNVALIDATED', -1 );
define( 'LEVEL_GUEST', 0 );
define( 'LEVEL_USER', 1 );
define( 'LEVEL_REDACTOR', 2 );
define( 'LEVEL_MODERATOR', 3 );
define( 'LEVEL_ADMINISTRATOR', 4 );

function checkUserParams($from)
{
	$return = array();
	/* Prototype
	 *	if( in_array( 7, $from ) )
	 *	{
	 *		$return .= '';
	 *	}
	*/
	if( in_array( 1, $from ) )
	{
		$return[] = 'Le pseudo est déjà pris';
	}
	if( in_array( 2, $from ) )
	{
		$return[] = 'Le pseudo doit faire moins de 15 caractères.';
	}
	if( in_array( 3, $from ) )
	{
		$return[] = 'Le mot de pass doit faire moins de 15 caractères.';
	}
	if( in_array( 4, $from ) )
	{
		$return[] = 'Les mots de pass ne correspondent pas.';
	}
	if( in_array( 5, $from ) )
	{
		$return[] = 'Le format de l\'addresse email est incorrecte';
	}
	if( in_array( 6, $from ) )
	{
		$return[] = 'L\'adresse email doit faire moins de 40 caractères.';
	}
	if( in_array( 7, $from ) )
	{
		$return[] = 'La taille de la date est incorrect';
	}
	if( in_array( 8, $from ) )
	{
		$return[] = 'Format de la date incorrect';
	}
	if( in_array( 9, $from ) )
	{
		$return[] = 'L\'email est déjà utilisée';
	}
	if( in_array( 10, $from ) )
	{
		$return[] = 'Le captcha n\'est pas bon';
	}
	if( in_array( 11, $from ) )
	{
		$return[] = 'Vous devez remplir tous les champs';
	}
	if( in_array( 12, $from ) )
	{
		$return[] = 'Le fichier de l\'avatar est trop gros';
	}
	if( in_array( 13, $from ) )
	{
		$return[] = 'L\'extension du fichier de l\'avatar est incorrecte';
	}
	if( in_array( 14, $from ) )
	{
		$return[] = 'L\'avatar est trop grand, il doit faire au maximum 120x120';
	}
	if( in_array( 15, $from ) )
	{
		$return[] = 'Le fichier de l\'avatar est manquant';
	}
	if( in_array( 16, $from ) )
	{
		$return[] = 'Erreur durant le transfert du fichier';
	}
	return '<li>' . implode( '</li><li>', $return ) . '</li>';
}

function isAjaxRequest()
{
	return ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' );
}

//Tranforme un array() en attributs HTML/CSS
function toHTMLAttr($attr, $for_CSS = false)
{
	//Ce n'est pas un array ?
	if( !is_array( $attr ) )
	{
		throw new Exception( __FUNCTION__ . '(' . var_dump( $attr, true ) . ') -> first parameter must be an array' );
	}
	//[STRING]Ce que contiendra le résultat
	$formattedElem = '';
	foreach( $attr as $key => $value )
	{
		//Si la valeur n'est pas vide (ignorage forcé)
		if( $value != NULL )
		{
			$formattedElem .= ' ' . $key . ( !$for_CSS ? '="' : ': ' ) . $value . ( !$for_CSS ? '"' : ";\n" );
		}
	}
	return $formattedElem;
}

function QSA($params)
{
	$str = '';
	if( count( $params ) )
	{
		$str .= '?';
		$first = true;
		foreach( $params as $key => $value )
		{
			$str .= ( ( !$first )?'&':'' );
			if( intval( $key ) !== $key ) //we are in a non-associative array context !
			{
				$str .= $key . '=';
			}
			$str .= $value;
		}
		if( $first )
			$first = false;
	}
	return $str;
}

function anchor($link, $text = NULL, $add_opt = NULL, $force_return = false)
{
	$params = '';
	if( $add_opt == NULL )
	{
		$add_opt = array();
	}
	if( isset( $add_opt['_get'] ) )
	{
		$params .= QSA( $add_opt['_get'] );
		unset( $add_opt['_get'] );
	}
	if( $link == NULL && $text != NULL )
	{
		$link = $text;
	}
	elseif( $text == NULL )
	{
		$text = ucfirst( $link );
	}
	$link = strtolower( $link );
	$opt = array_merge( $add_opt, array(
			'href' => ROOT . $link . GL_EXT,
		) );
	$str = '<a ' . toHTMLAttr( $opt ) . '>'
		. $text . '
	</a>';
	if( $force_return )
	{
		return $str;
	}
	else
	{
		echo $str;
	}
}