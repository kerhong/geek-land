<?php
	defined( 'PHP_EXT' ) || exit();
	$_SESSION = array();
	session_unset();
	session_destroy();
header( 'Location: http://geek-land.zxq.net/');