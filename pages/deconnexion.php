<?php
	$_SESSION = array();
	session_unset();
	session_destroy();
	echo 'Vous �tes bien d�conn�ct�';