<?php
	$_SESSION = array();
	session_unset();
	session_destroy();
	echo 'Vous êtes bien déconnécté';