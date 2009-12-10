<?php
	function out($var)
	{
		var_dump( View::$vars );
		echo View::$vars[$var];
	}