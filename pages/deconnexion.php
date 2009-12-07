<?php
	defined( 'PHP_EXT' ) || exit();
	$_SESION = array();
	session_unset();
	session_destroy();
	header( 'Location: ' . ROOT_URL );