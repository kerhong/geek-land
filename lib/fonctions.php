<?php
defined( 'PHP_EXT' ) || exit();

function inc( $class_name_ )
{
	$class_name = str_replace( array( '_', '\\', ), '/', $class_name_ );
	require_once 'lib/class/' . lcfirst( $class_name ) . PHP_EXT;
}

spl_autoload_register( 'inc' );

bdd::init();

//R�p�te un certain nombre de fois la balise <br />
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
	//[STRING]Ce que contiendra le r�sultat
	$formattedElem = '';
	foreach( $attr as $key => $value )
	{
		//Si la valeur n'est pas vide (ignorage forc�)
		if( $value != NULL )
		{
			$formattedElem .= ' ' . $key . ( !$for_CSS ? '="' : ': ' ) . $value . ( !$for_CSS ? '"' : ";\n" );
		}
	}
	return $formattedElem;
}