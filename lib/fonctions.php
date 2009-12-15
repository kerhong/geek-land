<?php
defined( 'PHP_EXT' ) || exit();
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

define( 'LEVEL_BANNED', -1 );
define( 'LEVEL_UNVALIDATED', 0 );
define( 'LEVEL_NORMAL_USER', 1 );
define( 'LEVEL_REDACTOR', 2 );
define( 'LEVEL_MODERATOR', 3 );
define( 'LEVEL_ADMINISTRATOR', 4 );

function checkUserParams($from)
{
	$return = '';
	/* Prototype
	 *	if( in_array( 7, $from ) )
	 *	{
	 *		$return .= '<li></li>';
	 *	}
	*/
	if( in_array( 1, $from ) )
	{
		$return .= '<li>Le pseudo est déjà pris</li>';
	}
	if( in_array( 2, $from ) )
	{
		$return .= '<li>Le pseudo doit faire moins de 15 caractères.</li>';
	}
	if( in_array( 3, $from ) )
	{
		$return .= '<li>Le mot de pass doit faire moins de 15 caractères.</li>';
	}
	if( in_array( 4, $from ) )
	{
		$return .= '<li>Les mots de pass ne correspondent pas.</li>';
	}
	if( in_array( 5, $from ) )
	{
		$return .= '<li>Le format de l\'addresse email est incorrecte</li>';
	}
	if( in_array( 7, $from ) )
	{
		$return .= '<li>La taille de la date est incorrect</li>';
	}
	if( in_array( 8, $from ) )
	{
		$return .= '<li>Format de la date incorrect</li>';
	}
	if( in_array( 6, $from ) )
	{
		$return .= '<li>L\'adresse email doit faire moins de 40 caractères.</li>';
	}
	if( in_array( 9, $from ) )
	{
		$return .= '<li>L\'email est déjà utilisée</li>';
	}
	if( in_array( 'c', $from ) )
	{
		$return .= '<li>Le captcha n\'est pas bon</li>';
	}
	return $return;
}

function check_auth( $auth_have, $auth_needed, $strict = false )
{
	return ( $strict )?( $auth_have > $auth_needed ):( $auth_have >= $auth_needed );
}

function encode($str)
{
	return utf8_encode( htmlentities( $str, ENT_QUOTES ) );
}
function relative_or_external($name, $add)
{
	$added = '';
	if( substr( $name, 0, 7 ) != 'http://' )
	{
		$added = ROOT . $add;
	}
	return $added . $name;
}

function has_extension($file, $ext, $return_file_too = false)
{
	$f = ( $return_file_too ) ? $file : '';
	if( substr( $file, - strlen( $ext ) ) != $ext )
	{
		return $f . $ext;
	}
	return $f;
}

function require_js()
{
	foreach( func_get_args() as $fichier_js )
	{
		echo '<script type="text/javascript" src="' . relative_or_external( $fichier_js, 'lib/' ) . has_extension( $fichier_js, '.js' ) .'?'
		 . rand( 0, 99999 ) . '"></script>' . "\n";
	}
}

function addBracket($str)
{
	$return = array();
	if( is_array( $str ) )
	{
		foreach( $str as $k )
		{
			$return[] = addBracket( $k );
		}
		return $return;
	}
	return '{' . $str . '}';
}
function addDoubleDot($str)
{
	if( $str[0] != ':' )
		{
			$str = ':' . $str;
		}
	return $str;
}

function isAjaxRequest()
{
	return ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' );
}

//Répète un certain nombre de fois la balise <br />
function doBR($i = 1)
{
	return str_repeat( '<br />', $i );
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

function anchor($link, $text = NULL, $add_opt = NULL, $force_return = false)
{
	if( $add_opt == NULL )
	{
		$add_opt = array();
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
			'href' => ROOT . $link . '.geek-land',
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