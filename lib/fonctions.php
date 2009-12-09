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

function inc( $class_name_ )
{
	$class_name = str_replace( array( '_', '\\', ), '/', $class_name_ );
	require_once 'lib/class/' . lcfirst( $class_name ) . PHP_EXT;
}

spl_autoload_register( 'inc' );

bdd::init();

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