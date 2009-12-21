<?php
	function out($var)
	{
		echo View::$vars[$var];
	}
	function redirect_to($page)
	{
		if( $page == ':root_url' )
		{
			$page = 'index';
		}
		header( 'Location: ' . ROOT . $page . GL_EXT );
		exit();
	}
	function validates_get_fields()
	{
		foreach( func_get_args() as $arg )
		{
			if( !isset( $_GET[$arg] ) )
			{
				$_GET[$arg] = NULL;
			}
		}
	}
	function validates_post_fields()
	{
		foreach( func_get_args() as $arg )
		{
			if( !isset( $_POST[$arg] ) )
			{
				$_POST[$arg] = NULL;
			}
		}
	}
	function check_auth( $auth_have, $auth_needed, $strict = false )
	{
		$auth_have = ( is_array( $auth_have ) )?( isset( $auth_have['level'] )?$auth_have['level']:LEVEL_GUEST ):$auth_have;
		return ( $strict )?( $auth_have > $auth_needed ):( $auth_have >= $auth_needed );
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
	function add_bracket($str)
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
	function add_double_dot($str)
	{
		if( $str[0] != ':' )
			{
				$str = ':' . $str;
			}
		return $str;
	}

	//Répète un certain nombre de fois la balise <br />
	function doBR($i = 1)
	{
		return str_repeat( '<br />', $i );
	}