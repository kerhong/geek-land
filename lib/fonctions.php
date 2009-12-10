<?php
defined( 'PHP_EXT' ) || exit();
define( 'ROOT_URL', 'http://geek-land.zxq.net' );
session_start();

if( !function_exists( 'lcfirst' ) )
{
	function lcfirst( $name )
	{
		$name[0] = strtolower( $name[0] );
		return $name;
	}
}

function inc( $class_name_ )
{
	$class_name = str_replace( array( '_', '\\', ), '/', $class_name_ );
	require_once ROOT . 'lib/class/' . lcfirst( $class_name ) . PHP_EXT;
}

spl_autoload_register( 'inc' );

Bdd::init();

function relative_or_external($name, $add)
{
	$added = '';
	if( substr( $name, 0, 7 ) != 'http://' )
	{
		$added = ROOT_URL . '/' . $add;
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
	if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ):
		return true;
	endif;
	return false;
}


//Répète un certain nombre de fois la balise <br />
function doBR($i = 1)
{
	return str_repeat( '<br />', $i );
}
//Tranforme un array() en attributs HTML/CSS
function toHTMLAttr( $attr, $for_CSS = false )
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